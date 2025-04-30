<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Hike;
use App\Models\Stage;
use App\Models\Stamp;
use App\Models\User;
use App\Models\StampComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StampTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_stamps_for_hike()
    {
        $hike = Hike::factory()->create(['id' => 1]); // For "OKT"
        $stage = Stage::factory()->create(['hike_id' => $hike->id]);
        Stamp::factory()->count(2)->create(['stage_id' => $stage->id, 'mtsz_id' => 'STAMP1']);

        $response = $this->get(route('stamps.index', ['hike' => 'OKT']));

        $response->assertStatus(200)
                 ->assertInertia(fn ($page) =>
                     $page->component('stamps/index')
                          ->where('hike', 'OKT')
                          ->has('stamps')
                          ->has('stages')
                 );
    }

    public function test_index_with_stage_filter()
    {
        $hike = Hike::factory()->create(['id' => 2]); // For "DDK"
        $stage = Stage::factory()->create(['hike_id' => $hike->id]);
        $stamp = Stamp::factory()->create(['stage_id' => $stage->id]);

        $response = $this->get(route('stamps.index', ['hike' => 'DDK', 'stage' => $stage->id]));

        $response->assertStatus(200)
                 ->assertInertia(fn ($page) =>
                     $page->component('stamps/index')
                          ->has('stagestamps')
                          ->where('stage.name', $stage->name)
                 );
    }

    public function test_show_displays_stamp_with_comments()
    {
        $stamp = Stamp::factory()->create(['mtsz_id' => 'MTSZ-123']);
        $user = User::factory()->create();
        StampComment::factory()->count(2)->create([
            'stamp_mtsz_id' => $stamp->mtsz_id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('stamps.show', ['stamp' => 'MTSZ-123']));

        $response->assertStatus(200)
                 ->assertInertia(fn ($page) =>
                     $page->component('stamps/show')
                          ->where('stamp.mtsz_id', 'MTSZ-123')
                          ->has('comments', 2)
                 );
    }
}
