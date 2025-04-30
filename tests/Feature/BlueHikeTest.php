<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hike;
use App\Models\BlueHike;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Testing\RefreshDatabase;

class BlueHikeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_index_displays_user_bluehikes()
    {
        $user = User::factory()->create();
        $user->bluehikes()->create(BlueHike::factory()->raw());

        $response = $this->actingAs($user)->get(route('bluehikes.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('bluehikes/index')
            ->has('bluehikes'));
    }

    public function test_plannedhikes_page_loads()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('bluehikes.plannedhikes'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('bluehikes/plannedhikes')
            ->has('plannedhikes'));
    }

    public function test_user_can_complete_a_hike()
    {
        $user = User::factory()->create();
        $bluehike = BlueHike::factory()->create([
            'user_id' => $user->id,
            'completed' => 0,
        ]);

        $response = $this->actingAs($user)->post(route('bluehikes.completehike'), [
            'id' => $bluehike->id
        ]);

        $response->assertRedirect(route('bluehikes.index'));
        $this->assertDatabaseHas('blue_hikes', [
            'id' => $bluehike->id,
            'completed' => 1,
        ]);
    }

    public function test_user_can_store_a_new_hike()
    {
        $user = User::factory()->create();
        $hike = Hike::factory()->create();

        $data = [
            'name' => 'Test Hike',
            'user_id' => $user->id,
            'hike_id' => $hike->id,
            'isCustomStart' => true,
            'start_point' => 1,
            'isCustomEnd' => true,
            'end_point' => 2,
            'date' => now()->toDateString(),
            'completed' => true,
            'distance' => 12.5,
            'diary' => 'Sample notes...',
            'gpx' => '<gpx>data</gpx>'
        ];

        $this->actingAs($user)->post(route('bluehikes.store'), $data);

        Storage::disk('local')->assertExists($user->email . '/blueroutes/Test Hike.gpx');

        $this->assertDatabaseHas('blue_hikes', [
            'name' => 'Test Hike',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_see_another_users_bluehike()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $hike = BlueHike::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get(route('bluehikes.show', $hike));

        $response->assertRedirect(route('bluehikes.index'));
    }

    public function test_user_can_delete_a_bluehike()
    {
        $user = User::factory()->create();
        $bluehike = BlueHike::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Hike',
        ]);
        Storage::disk('local')->put($user->email . '/blueroutes/Test Hike.gpx', 'dummy content');

        $response = $this->actingAs($user)->delete(route('bluehikes.destroy', $bluehike));

        $response->assertRedirect(route('bluehikes.index'));
        $this->assertDatabaseMissing('blue_hikes', ['id' => $bluehike->id]);
        Storage::disk('local')->assertMissing($user->email . '/blueroutes/Test Hike.gpx');
    }
}
