<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\Standing;
use App\Services\StandingsService;
use App\Services\SimulatorService;
use Illuminate\Support\Collection;

class SimulatorHelper
{
    private SimulatorService $simulatorService;
    private StandingsService $standingsService;

    public function __construct(SimulatorService $simulatorService, StandingsService $standingsService)
    {
        $this->simulatorService = $simulatorService;
        $this->standingsService = $standingsService;
    }

    public function simulate(Collection $games)
    {
        foreach ($games as $game) {
            $this->simulatorService->simulateGame($game, $game->teamA->power, $game->teamB->power)->save();
            $standings = Standing::query()->whereIn('team_id', [$game->team_a, $game->team_b])->get();
            $standings = $this->standingsService->calculateGame($game, $standings);
            foreach ($standings as $standing){
                $standing->save();
            }
        }
    }
}
