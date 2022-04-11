<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamsControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use HasFactory;

    public function testEmptyTeams()
    {
        $response = $this->get('/api/teams');
        $response->assertStatus(200);
        $this->assertEquals([],$response->json());
    }

    public function testTeams()
    {
        $teamsCount = 4;
        Team::factory()->count($teamsCount)->create();
        $response = $this->get('/api/teams');

        $response->assertStatus(200);
        $response->assertJsonStructure(['*' => ['id', 'name', 'power']]);
        $this->assertEquals($teamsCount, count($response->json()));
    }
}
