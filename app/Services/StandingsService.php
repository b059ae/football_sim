<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Standing;
use Illuminate\Support\Collection;
use function DeepCopy\deep_copy;

class StandingsService
{
    /**
     * @param Game $game
     * @param Collection<Standing> $currentStandings
     * @return Collection<Standing>
     * @throws \Exception
     */
    public function calculateGame(Game $game, Collection $currentStandings): Collection
    {
        if ($currentStandings->count() != 2) {
            throw new \Exception('standings count must be equal 2');
        }
        $standings = deep_copy($currentStandings->keyBy('team_id'));
        if (!isset($standings[$game->team_a]) || !isset($standings[$game->team_b])) {
            throw new \Exception('standings does not contain game teams');
        }
        if ($game->team_a_goals > $game->team_b_goals){
            $standings[$game->team_a]->points += 3;
            $standings[$game->team_a]->wins += 1;
            $standings[$game->team_b]->loses += 1;
        }elseif ($game->team_a_goals < $game->team_b_goals){
            $standings[$game->team_a]->loses += 1;
            $standings[$game->team_b]->wins += 1;
            $standings[$game->team_b]->points += 3;
        }else{
            $standings[$game->team_a]->drafts += 1;
            $standings[$game->team_a]->points += 1;
            $standings[$game->team_b]->drafts += 1;
            $standings[$game->team_b]->points += 1;
        }
        $standings[$game->team_a]->goals_diff += $game->team_a_goals - $game->team_b_goals;
        $standings[$game->team_b]->goals_diff += $game->team_b_goals - $game->team_a_goals;

        return $standings;
    }
}
