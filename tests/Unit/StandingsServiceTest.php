<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Standing;
use App\Services\StandingsService;
use PHPUnit\Framework\TestCase;

class StandingsServiceTest extends TestCase
{
    private StandingsService $service;
    /** @var Game[] */
    private array $games;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StandingsService();
        $this->games = [
            new Game(['team_a' => 1, 'team_a_goals' => 2, 'team_b_goals' => 1, 'team_b' => 2]),
            new Game(['team_a' => 1, 'team_a_goals' => 0, 'team_b_goals' => 2, 'team_b' => 2]),
            new Game(['team_a' => 1, 'team_a_goals' => 1, 'team_b_goals' => 1, 'team_b' => 2]),
        ];
    }

    public function testValidateResultTeams()
    {
        $this->expectException(\Exception::class);
        $results = collect([
            new Standing(['team_id' => 1]),
            new Standing(['team_id' => 3]),
        ]);
        $this->service->calculateGame($this->games[0], $results);
    }

    public function testValidateResultCount()
    {
        $this->expectException(\Exception::class);
        $results = collect([
            new Standing(['team_id' => 1]),
        ]);
        $this->service->calculateGame($this->games[0], $results);
    }

    public function testCalculateGame()
    {
        $currentResults = collect([
            new Standing(['team_id' => 1, 'wins' => 1, 'loses' => 1, 'drafts' => 1, 'points' => 4, 'goals_diff' => 4]),
            new Standing(['team_id' => 2, 'wins' => 3, 'loses' => 3, 'drafts' => 2, 'points' => 11, 'goals_diff' => -1]),
        ]);
        $expectedResults = [
            [
                1 => ['wins' => 2, 'loses' => 1, 'drafts' => 1, 'points' => 7, 'goals_diff' => 5],
                2 => ['wins' => 3, 'loses' => 4, 'drafts' => 2, 'points' => 11, 'goals_diff' => -2],
            ],
            [
                1 => ['wins' => 1, 'loses' => 2, 'drafts' => 1, 'points' => 4, 'goals_diff' => 2],
                2 => ['wins' => 4, 'loses' => 3, 'drafts' => 2, 'points' => 14, 'goals_diff' => 1],
            ],
            [
                1 => ['wins' => 1, 'loses' => 1, 'drafts' => 2, 'points' => 5, 'goals_diff' => 4],
                2 => ['wins' => 3, 'loses' => 3, 'drafts' => 3, 'points' => 12, 'goals_diff' => -1],
            ],
        ];
        foreach ($this->games as $gameId => $game) {
            $calculatedResults = $this->service->calculateGame($game, $currentResults);
            $calculatedResults = $calculatedResults->keyBy('team_id');
            $this->assertContainsOnlyInstancesOf(
                Standing::class,
                $calculatedResults
            );
            foreach ([1, 2] as $team) {
                foreach (array_keys($expectedResults[$gameId][$team]) as $key) { // key = ['wins', 'loses', ...]
                    $this->assertEquals($expectedResults[$gameId][$team][$key], $calculatedResults[$team]->$key);
                }
            }
        }

    }
}
