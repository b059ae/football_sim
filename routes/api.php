<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\StandingsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WinnersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/standings', [StandingsController::class, 'index']);
Route::get('/status', [StatusController::class, 'index']);
Route::get('/games', [GamesController::class, 'index']);
Route::get('/games/last', [GamesController::class, 'last']);
Route::get('/games/next', [GamesController::class, 'next']);
Route::post('/games/generate', [GamesController::class, 'generate']);
Route::post('/games/reset', [GamesController::class, 'reset']);
Route::post('/games/playNext', [GamesController::class, 'playNext']);
Route::post('/games/playAll', [GamesController::class, 'playAll']);
Route::get('/winners', [WinnersController::class, 'index']);
