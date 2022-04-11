<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Helpers\FixturesHelper;
use App\Helpers\SimulatorHelper;
use App\Helpers\StatusHelper;
use App\Models\Game;
use App\Services\FixturesService;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::query()->get();
        return response()->json($games);
    }

    public function last()
    {
        $games = Game::query()->lastGames()->get();
        return response()->json($games);
    }

    public function next()
    {
        $games = Game::query()->nextGames()->get();

        return response()->json($games);
    }

    public function generate(FixturesService $fixturesService)
    {
        $status = StatusHelper::get();
        if ($status !== Status::NOT_STARTED){
            abort(500, 'Fixtures already been generated');
        }

        FixturesHelper::generate($fixturesService);
    }

    public function playNext(SimulatorHelper $simulatorHelper)
    {
        $status = StatusHelper::get();
        if ($status !== Status::IN_PROGRESS){
            abort(500, 'Championship is not in progress');
        }
        $games = Game::query()->nextGames()->get();
        $simulatorHelper->simulate($games);
    }

    public function playAll(SimulatorHelper $simulatorHelper)
    {
        $status = StatusHelper::get();
        if ($status !== Status::IN_PROGRESS){
            abort(500, 'Championship is not in progress');
        }
        $games = Game::with(['teamA','teamB'])->whereNull('team_a_goals')->get();
        $simulatorHelper->simulate($games);
    }

    public function reset()
    {
        FixturesHelper::reset();
    }
}
