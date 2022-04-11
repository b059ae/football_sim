<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Standing;
use App\Services\PredictionService;
use Illuminate\Http\Request;

class WinnersController extends Controller
{
    public function index(PredictionService $predictionService)
    {
        $standings = Standing::select('team_id', 'points')->get();
        $games = Game::where('team_a_goals', null)->get();
        $weeksLeft = $games->unique('week')->count();
        if ($weeksLeft > 2 || $weeksLeft === 0){
            $winners = $predictionService->zeroValues($standings);
        }else{
            $winners = $predictionService->predict($standings, $games);
        }

        return response()->json($winners);
    }
}
