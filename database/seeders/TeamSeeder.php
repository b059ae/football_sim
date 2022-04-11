<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    private const TEAMS = [
        'Manchester City',
        'Liverpool',
        'Chelsea',
        'Tottenham',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::TEAMS as $team){
            Team::create([
                'name' => $team,
                'power' => rand(60, 100),
            ]);
        }
    }
}
