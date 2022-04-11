<?php

namespace App\Services;

use App\Models\Game;

class SimulatorService
{
    private const DEFAULT_WEIGHTS = [
        0 => 75,
        1 => 25,
        2 => 12,
        3 => 6,
        4 => 3,
        5 => 2,
        6 => 1,
        7 => 1,
        8 => 1,
        9 => 1,
    ];

    public function simulateGame(Game $game, $powerA, $powerB): Game
    {
        $game->team_a_goals =  $this->getRandomWeightedElement($powerA, $powerB);
        $game->team_b_goals = $this->getRandomWeightedElement($powerB, $powerA);

        return $game;
    }

    private function getRandomWeightedElement(int $powerA, int $powerB): int
    {
        $weightedValues = $this->getWeightedValues($powerA,$powerB );
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }

        return 0;
    }

    /**
     * @param int $powerA
     * @param int $powerB
     * @return int[]
     */
    private function getWeightedValues(int $powerA, int $powerB): array
    {
        $diff = (int) floor(($powerA - $powerB) / 10);
        if ($diff <= 0) {
            return self::DEFAULT_WEIGHTS; // default values
        }
        $weights = [];
        for ($i = 0; $i < 10; $i++) { // calculate bonus
            $weights[$i] = self::DEFAULT_WEIGHTS[abs($diff-$i)];
        }
        return $weights;
    }
}
