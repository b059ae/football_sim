<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Standing;
use App\Models\Team;
use App\Services\PredictionService;
use Illuminate\Console\Command;
use function \nspl\a\cartesianProduct;

class PredictionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prediction:run';

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
    public function handle(PredictionService $predictionService)
    {
        $standings = Standing::select('team_id', 'points')->get();
        $games = Game::where('team_a_goals', null)->get();

        $winners = $predictionService->predict($standings, $games);

        return 0;
    }
}
