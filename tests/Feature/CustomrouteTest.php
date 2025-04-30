<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CustomRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class CustomrouteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_index_displays_user_customroutes()
    {
        $user = User::factory()->create();
        $user->croutes()->create(CustomRoute::factory()->raw());

        $response = $this->actingAs($user)->get(route('customroutes.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('customroutes/index')
            ->has('customroutes'));
    }

    public function test_create_displays_the_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('customroutes.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('customroutes/customroute'));
    }

    public function test_store_saves_new_custom_route()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'My Route',
            'user_id' => $user->id,
            'gpx' => '<gpx>Example</gpx>',
        ];

        $response = $this->post(route('customroutes.store'), $data);

        $response->assertRedirect(route('customroutes.index'));
        $this->assertDatabaseHas('customroutes', ['name' => 'My Route', 'user_id' => $user->id]);
        Storage::disk('local')->assertExists("{$user->email}/croutes/My Route.gpx");
    }

    public function test_store_rejects_duplicate_name()
    {
        $user = User::factory()->create();
        CustomRoute::factory()->create(['user_id' => $user->id, 'name' => 'My Route']);
        $this->actingAs($user);

        $data = [
            'name' => 'My Route',
            'user_id' => $user->id,
            'gpx' => '<gpx>Duplicate</gpx>',
        ];

        $response = $this->post(route('customroutes.store'), $data);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_user_can_view_their_custom_route()
    {
        $user = User::factory()->create();
        $route = CustomRoute::factory()->create(['user_id' => $user->id, 'name' => 'ViewRoute']);
        Storage::disk('local')->put("{$user->email}/croutes/ViewRoute.gpx", '<gpx>Sample</gpx>');

        $response = $this->actingAs($user)->get(route('customroutes.show', $route->id));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('customroutes/show')
            ->where('name', 'ViewRoute'));
    }

    public function test_user_cannot_view_others_custom_route()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $route = CustomRoute::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get(route('customroutes.show', $route->id));

        $response->assertRedirect(route('customroutes.index'));
    }

    public function test_user_can_delete_custom_route()
    {
        $user = User::factory()->create();
        $route = CustomRoute::factory()->create(['user_id' => $user->id, 'name' => 'DeleteMe']);
        Storage::disk('local')->put("{$user->email}/croutes/DeleteMe.gpx", 'test content');

        $response = $this->actingAs($user)->delete(route('customroutes.destroy', $route->id));

        $response->assertRedirect(route('customroutes.index'));
        $this->assertDatabaseMissing('customroutes', ['id' => $route->id]);
        Storage::disk('local')->assertMissing("{$user->email}/croutes/DeleteMe.gpx");
    }
}
