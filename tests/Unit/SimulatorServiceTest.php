<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Services\SimulatorService;
use PHPUnit\Framework\TestCase;

class SimulatorServiceTest extends TestCase
{
    private SimulatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SimulatorService();
    }

    public function testSimulateGame()
    {
        $game = new Game(['team_a' => 1, 'team_b' => 2]);
        $powerA = rand(60, 100);
        $powerB = rand(0, 60);
        $this->service->simulateGame($game, $powerA, $powerB);
        $this->assertIsNumeric($game->team_a_goals);
        $this->assertIsNumeric($game->team_b_goals);
        $this->assertGreaterThanOrEqual(0, $game->team_a_goals);
        $this->assertGreaterThanOrEqual(0, $game->team_b_goals);
    }
}
