<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Helpers\FixturesHelper;
use App\Helpers\SimulatorHelper;
use App\Models\Game;
use App\Models\Team;
use App\Services\FixturesService;
use App\Services\StandingsService;
use App\Services\SimulatorService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use HasFactory;

    public function testNotStarted()
    {
        $teamsCount = 2;
        Team::factory()->count($teamsCount)->create();
        $response = $this->get('/api/status');
        $response->assertStatus(200);
        $this->assertEquals(Status::NOT_STARTED, $response->json());
    }

    public function testInProgress()
    {
        $teamsCount = 2;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->get('/api/status');
        $response->assertStatus(200);
        $this->assertEquals(Status::IN_PROGRESS, $response->json());
    }

    public function testFinished()
    {
        $teamsCount = 2;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $games = Game::query()->whereNull('team_a_goals')->get();
        (new SimulatorHelper(new SimulatorService(), new StandingsService()))->simulate($games);
        $response = $this->get('/api/status');
        $response->assertStatus(200);
        $this->assertEquals(Status::FINISHED, $response->json());
    }
}
