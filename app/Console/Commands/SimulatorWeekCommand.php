<?php

namespace App\Console\Commands;

use App\Helpers\SimulatorHelper;
use App\Models\Game;
use App\Services\StandingsService;
use App\Services\SimulatorService;
use Illuminate\Console\Command;

class SimulatorWeekCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:week';

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
    public function handle(SimulatorHelper $simulatorHelper)
    {
        $simulatorHelper->playNext();
        return 0;
    }
}
