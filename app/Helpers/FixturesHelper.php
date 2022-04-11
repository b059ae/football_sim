<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\Standing;
use App\Models\Team;
use App\Services\FixturesService;
use Illuminate\Support\Facades\DB;

class FixturesHelper
{
    public static function generate(FixturesService $service)
    {
        $teams = Team::select('id')->get()->pluck('id')->toArray();
        $games = $service->generateGames($teams);
        $standings = $service->generateStandings($teams);

        DB::beginTransaction();
        array_map(function($game) {
            $game->save();
        }, $games);

        array_map(function($standing) {
            $standing->save();
        }, $standings);
        DB::commit();
    }

    public static function reset()
    {
        DB::beginTransaction();
        Game::truncate();
        Standing::truncate();
        DB::commit();
    }
}
