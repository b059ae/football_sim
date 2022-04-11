<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use Illuminate\Http\Request;

class StandingsController extends Controller
{
    public function index()
    {
        $standings = Standing::query()->get();
        return response()->json($standings);
    }
}
