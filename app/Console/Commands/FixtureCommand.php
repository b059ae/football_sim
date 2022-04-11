<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\FixturesService;
use Illuminate\Console\Command;

class FixtureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixture:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FixturesService $service)
    {
        $teams = Team::select('id')->get()->pluck('id')->toArray();
        $games = $service->generateGames($teams);
        $standings = $service->generateStandings($teams);

        array_map(function($game) {
            $game->save();
        }, $games);

        array_map(function($standing) {
            $standing->save();
        }, $standings);
        return 0;
    }
}
