<?php

namespace Tests\Feature;

use App\Helpers\FixturesHelper;
use App\Helpers\SimulatorHelper;
use App\Models\Game;
use App\Models\Standing;
use App\Models\Team;
use App\Services\FixturesService;
use App\Services\StandingsService;
use App\Services\SimulatorService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GamesControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use HasFactory;

    public function testEmptyIndex()
    {
        $response = $this->get('/api/games');

        $response->assertStatus(200);
        $this->assertEquals([], $response->json());
    }

    public function testIndex()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->get('/api/games');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'team_a', 'team_a_goals', 'team_b_goals', 'team_b', 'week']
        ]);
        $this->assertEquals($teamsCount * ($teamsCount - 1), count($response->json()));
    }

    public function testEmptyLast()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->get('/api/games/last');

        $response->assertStatus(200);
        $this->assertEquals([], $response->json());
    }

    public function testLast()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $games = Game::query()->where('week', 1)->get();
        (new SimulatorHelper(new SimulatorService(), new StandingsService()))->simulate($games);
        $response = $this->get('/api/games/last');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'team_a', 'team_a_goals', 'team_b_goals', 'team_b', 'week']
        ]);
        $this->assertEquals(2, count($response->json()));
    }

    public function testEmptyNext()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $games = Game::query()->get();
        (new SimulatorHelper(new SimulatorService(), new StandingsService()))->simulate($games);
        $response = $this->get('/api/games/next');

        $response->assertStatus(200);
        $this->assertEquals([], $response->json());
    }

    public function testNext()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->get('/api/games/next');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'team_a', 'team_a_goals', 'team_b_goals', 'team_b', 'week']
        ]);
        $this->assertEquals(2, count($response->json()));
    }

    public function testGenerate()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        $response = $this->post('/api/games/generate');

        $gamesCount = Game::query()->count();
        $standingsCount = Standing::query()->count();
        $response->assertStatus(200);
        $this->assertEquals($teamsCount*($teamsCount-1), $gamesCount);
        $this->assertEquals($teamsCount, $standingsCount);
    }

    public function testSecondGenerate()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->post('/api/games/generate');

        $games = Game::query()->get();
        $response->assertStatus(500);
    }

    public function testReset()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->post('/api/games/reset');

        $gamesCount = Game::query()->count();
        $standingsCount = Standing::query()->count();
        $response->assertStatus(200);
        $this->assertEquals(0, $gamesCount);
        $this->assertEquals(0, $standingsCount);
    }

    public function testPlayNext()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->post('/api/games/playNext');

        $gamesCount = Game::query()->whereNull('team_a_goals')->count();
        $response->assertStatus(200);
        $this->assertEquals($teamsCount*($teamsCount-1)-$teamsCount/2, $gamesCount);
    }

    public function testPlayAll()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->post('/api/games/playAll');

        $gamesCount = Game::query()->whereNull('team_a_goals')->count();
        $response->assertStatus(200);
        $this->assertEquals(0, $gamesCount);
    }
}
