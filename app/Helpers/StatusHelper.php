<?php

namespace App\Helpers;

use App\Enums\Status;
use App\Models\Game;
use App\Models\Standing;

class StatusHelper
{
    public static function get(): string
    {
        if (Standing::query()->count() === 0){
            return Status::NOT_STARTED;
        }elseif((new Game())->nextWeek() === null){
            return Status::FINISHED;
        }else{
            return Status::IN_PROGRESS;
        }
    }
}
