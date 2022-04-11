<?php

namespace Tests\Feature;

use App\Helpers\FixturesHelper;
use App\Models\Team;
use App\Services\FixturesService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StandingsControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use HasFactory;

    public function testEmptyStandings()
    {
        $response = $this->get('/api/standings');

        $response->assertStatus(200);
        $this->assertEquals([], $response->json());
    }


    public function testStandings()
    {
        $teamsCount = 2;
        Team::factory()->count($teamsCount)->create();
        FixturesHelper::generate(new FixturesService());
        $response = $this->get('/api/standings');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'team_id', 'points', 'wins', 'drafts', 'loses', 'goals_diff']
        ]);
        $this->assertEquals($teamsCount, count($response->json()));
    }
}
