<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class Winner extends DataTransferObject
{
    public int $team_id;
    public float $probability;
}
