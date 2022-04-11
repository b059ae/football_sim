<?php

namespace App\Console\Commands;

use App\Helpers\SimulatorHelper;
use Illuminate\Console\Command;

class SimulatorAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:all';

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
        $simulatorHelper->playAll();
        return 0;
    }
}
