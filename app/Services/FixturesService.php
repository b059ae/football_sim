<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Standing;

class FixturesService
{

    /**
     * @param int[] $teams IDs of teams
     * @return Game[]
     * @throws \Exception
     */
    public function generateGames(array $teams): array
    {
        $count = count($teams);
        if ($count < 2) {
            throw new \Exception('teams count must be greater than 2');
        }
        if ($count % 2 == 1) {
            throw new \Exception('teams count must be even');
        }

        $totalRounds = $count - 1;
        $matchesPerRound = $count / 2;
        $games = [];

        for ($round = 0; $round < $totalRounds; $round++) {
            for ($match = 0; $match < $matchesPerRound; $match++) {
                $teamA = ($round + $match) % ($count - 1);
                $teamB = ($count - 1 - $match + $round) % ($count - 1);
                // Last team stays in the same place while the others
                // rotate around it.
                if ($match == 0) {
                    $teamB = $count - 1;
                }
                $games[] = new Game([
                    'team_a' => $teams[$teamA],
                    'team_b' => $teams[$teamB],
                    'week' => $round + 1,
                ]);
                $games[] = new Game([
                    'team_a' => $teams[$teamB],
                    'team_b' => $teams[$teamA],
                    'week' => $round + $totalRounds + 1,
                ]);
            }
        }

        return $games;
    }

    /**
     * @param int[] $teams
     * @return Standing[]
     */
    public function generateStandings(array $teams): array
    {
        $standings = [];
        foreach ($teams as $team) {
            $standings[] = new Standing(['team_id' => $team]);
        }
        return $standings;
    }
}
