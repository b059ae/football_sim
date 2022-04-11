<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NOT_STARTED()
 * @method static static IN_PROGRESS()
 * @method static static FINISHED()
 */
final class Status extends Enum
{
    const NOT_STARTED = 'not_started';
    const IN_PROGRESS = 'in_progress';
    const FINISHED = 'finished';
}
