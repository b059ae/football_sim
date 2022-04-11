<?php

namespace App\Services;

use App\DTO\Winner;
use App\Models\Game;
use App\Models\Standing;
use Illuminate\Support\Collection;
use function nspl\a\cartesianProduct;

class PredictionService
{
    /**
     * @param Collection<Standing> $currentStandings
     * @param Collection<Game> $gamesLeft
     * @return Winner[]
     * @throws \Exception
     */
    public function predict(Collection $currentStandings, Collection $gamesLeft): array
    {
        if ($gamesLeft->count() === 0) {
            throw new \Exception('games left must be not empty');
        }

        $standings = $currentStandings->pluck('points', 'team_id');

        $possibleStandings = $this->getPossibleStandings($gamesLeft);
        $predictions = [];
        $count = 0;
        foreach ($standings as $teamId => $standing) {
            $predictions[$teamId] = 0;
        }
        foreach ($possibleStandings as $possibleStanding) {
            $prediction = $standings->toArray();
            foreach ($possibleStanding as $i => $points) {
                $teamA = $gamesLeft[$i]->team_a;
                $teamB = $gamesLeft[$i]->team_b;
                $prediction[$teamA] += (int)$points[0];
                $prediction[$teamB] += (int)$points[1];
            }
            $maxPoint = max($prediction);
            foreach($prediction as $teamId => $points){
                if ($points === $maxPoint){
                    $predictions[$teamId]++;
                    $count++;
                }
            }

        }
        $winners = [];
        foreach ($predictions as $team => $winner) {
            $winners[] = new Winner([
                'team_id' => $team,
                'probability' => $winner / $count,
            ]);
        }

        return $winners;
    }

    public function zeroValues(Collection $currentStandings): array
    {
        $winners = [];
        foreach ($currentStandings as $currentStanding) {
            $winners[] = new Winner([
                'team_id' => $currentStanding->team_id,
                'probability' => 0,
            ]);
        }

        return $winners;
    }

    private function getPossibleStandings(Collection $gamesLeft): array
    {
        $score = [];
        foreach ($gamesLeft as $game) {
            $score[] = ['30', '11', '03']; // Win1 Draft Win2
        }
        return cartesianProduct($score);
    }

}
