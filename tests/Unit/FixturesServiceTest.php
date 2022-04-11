<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Standing;
use App\Services\FixturesService;
use PHPUnit\Framework\TestCase;

class FixturesServiceTest extends TestCase
{
    private FixturesService $service;
    private array $teams = [1,2,3,4];
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FixturesService();
    }

    public function testValidateEmptyTeams()
    {
        $this->expectException(\Exception::class);
        $teams = [];
        $this->service->generateGames($teams);
    }

    public function testValidateOddTeams()
    {
        $this->expectException(\Exception::class);
        $teams = [1];
        $this->service->generateGames($teams);
    }

    public function testGenerateGames()
    {
        $teamsCount = count($this->teams);
        $games = $this->service->generateGames($this->teams);

        $expectedGamesCount = $teamsCount*($teamsCount-1);
        $gamesCount = count($games);

        $gamesCollection = collect($games);
        $uniqueGamesCount = $gamesCollection->unique(function ($item) {
            return $item['team_a']."v".$item['team_b'];
        })->count();

        $expectedWeeksCount = ($teamsCount-1)*2;
        $weeksCount = $gamesCollection->unique('week')->count();

        $this->assertEquals($expectedGamesCount, $gamesCount);
        $this->assertEquals($expectedGamesCount, $uniqueGamesCount); // All games are unique
        $this->assertEquals($expectedWeeksCount, $weeksCount);
        $this->assertContainsOnlyInstancesOf(
            Game::class,
            $games
        );
    }


    public function testGenerateResults()
    {
        $teamsCount = count($this->teams);
        $results = $this->service->generateStandings($this->teams);
        $resultsCount = count($results);

        $this->assertEquals($teamsCount, $resultsCount);
        $this->assertContainsOnlyInstancesOf(
            Standing::class,
            $results
        );
    }
}
