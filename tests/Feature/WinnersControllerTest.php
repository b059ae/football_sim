<?php

namespace Tests\Feature;

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

class WinnersControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use HasFactory;

    public function testWinners()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $games = Game::query()->where('week', '<', 4)->get();
        (new SimulatorHelper(new SimulatorService(), new StandingsService()))->simulate($games);
        $response = $this->get('/api/winners');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['team_id', 'probability']
        ]);
        $this->assertEquals($teamsCount, count($response->json()));
    }
}
