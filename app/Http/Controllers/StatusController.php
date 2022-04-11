<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;

class StatusController extends Controller
{
    public function index()
    {
        return response()->json(StatusHelper::get());
    }

}
