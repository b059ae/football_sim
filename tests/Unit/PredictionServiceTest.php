<?php

namespace Tests\Unit;

use App\DTO\Winner;
use App\Models\Game;
use App\Models\Standing;
use App\Services\PredictionService;
use PHPUnit\Framework\TestCase;

class PredictionServiceTest extends TestCase
{
    private PredictionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PredictionService();
    }

    public function testValidateGamesLeft()
    {
        $this->expectException(\Exception::class);
        $games = collect([]);
        $results = collect([]);
        $this->service->predict($results, $games);
    }

    public function testPredict()
    {
        $gamesLeft = collect([
            new Game(['team_a' => 4, 'team_b' => 2]),
            new Game(['team_a' => 1, 'team_b' => 3]),
            new Game(['team_a'=> 4, 'team_b'=> 3]),
            new Game(['team_a'=> 2, 'team_b'=> 1]),
        ]);
        $currentResults = [
            collect([
                new Standing(['team_id' => 1, 'points' => 3]),
                new Standing(['team_id' => 2, 'points' => 4]),
                new Standing(['team_id' => 3, 'points' => 16]),
                new Standing(['team_id' => 4, 'points' => 9]),
            ]),
            collect([
                new Standing(['team_id' => 1, 'points' => 3]),
                new Standing(['team_id' => 2, 'points' => 10]),
                new Standing(['team_id' => 3, 'points' => 10]),
                new Standing(['team_id' => 4, 'points' => 3]),
            ]),
            collect([
                new Standing(['team_id' => 1, 'points' => 6]),
                new Standing(['team_id' => 2, 'points' => 6]),
                new Standing(['team_id' => 3, 'points' => 6]),
                new Standing(['team_id' => 4, 'points' => 6]),
            ]),
        ];
        $expectedWinners = [
            [
                new Winner(['team_id' => 1, 'probability' => 0.0]),
                new Winner(['team_id' => 2, 'probability' => 0.0]),
                new Winner(['team_id' => 3, 'probability' => 1.0]),
                new Winner(['team_id' => 4, 'probability' => 0.0]),
            ],
            [
                new Winner(['team_id' => 1, 'probability' => 0.0]),
                new Winner(['team_id' => 2, 'probability' => 0.5]),
                new Winner(['team_id' => 3, 'probability' => 0.5]),
                new Winner(['team_id' => 4, 'probability' => 0.0]),
            ],
            [
                new Winner(['team_id' => 1, 'probability' => 0.25]),
                new Winner(['team_id' => 2, 'probability' => 0.25]),
                new Winner(['team_id' => 3, 'probability' => 0.25]),
                new Winner(['team_id' => 4, 'probability' => 0.25]),
            ],
        ];
        foreach ($currentResults as $i => $currentResult) {
            $prediction = $this->service->predict($currentResult, $gamesLeft);
            $this->assertEquals($expectedWinners[$i], $prediction);
            $this->assertContainsOnlyInstancesOf(
                Winner::class,
                $prediction
            );
        }

    }
}
