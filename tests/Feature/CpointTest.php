<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stage;
use App\Models\Cpoint;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_user_cpoints()
    {
        $user = User::factory()->create();
        $cpoints = Cpoint::factory()->count(2)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('custompoints.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn($page) =>
                $page->component('custompoints/index')
                    ->has('points', 2)
            );
    }

    public function test_create_displays_stage_categories()
    {
        Stage::factory()->create(['name' => 'OKT Something']);
        Stage::factory()->create(['name' => 'DDK Something']);
        Stage::factory()->create(['name' => 'AK Something']);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('custompoints.create'))
            ->assertStatus(200)
            ->assertInertia(
                fn($page) =>
                $page->component('custompoints/create')
                    ->has('oktstages')
                    ->has('ddkstages')
                    ->has('akstages')
            );
    }

    public function test_store_creates_new_cpoint()
    {
        $user = User::factory()->create();
        $stage = Stage::factory()->create();

        $this->actingAs($user)
            ->post(route('custompoints.store'), [
                'name' => 'My Custom Point',
                'lat' => 47.5,
                'lon' => 19.0,
                'stage_id' => $stage->id,
                'user_id' => $user->id
            ])
            ->assertRedirect(route('custompoints.index'));

        $this->assertDatabaseHas('cpoints', [
            'name' => 'My Custom Point',
            'lat' => 47.5,
            'lon' => 19.0,
            'stage_id' => $stage->id,
            'user_id' => $user->id
        ]);
    }

    public function test_store_rejects_duplicate_name()
    {
        $user = User::factory()->create();
        Cpoint::factory()->create(['name' => 'Duplicate', 'user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('custompoints.store'), [
                'name' => 'Duplicate',
                'lat' => 47.5,
                'lon' => 19.0,
                'stage_id' => null,
                'user_id' => $user->id
            ])
            ->assertSessionHasErrors(['name']);
    }
}
