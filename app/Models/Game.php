<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_a',
        'team_b',
        'team_a_goals',
        'team_b_goals',
        'week',
    ];

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b');
    }

    public function scopeLastGames($query)
    {
        return $query->where('week', $this->lastWeek());
    }

    public function scopeNextGames($query)
    {
        return $query->where('week', $this->nextWeek());
    }

    public function nextWeek(): ?int
    {
        return self::whereNull('team_a_goals')->min('week');
    }

    public function lastWeek(): ?int
    {
        return self::whereNotNull('team_a_goals')->max('week');
    }


}
