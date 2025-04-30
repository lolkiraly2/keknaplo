<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Grouphike;
use App\Models\Customroute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GrouphikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_public_future_grouphikes()
    {
        Grouphike::factory()->create(["public" => true, "date" => Carbon::tomorrow()]);

        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('grouphikes.index'))
            ->assertStatus(200);

    }

    public function test_store_creates_new_grouphike()
    {
        $user = User::factory()->create();
        $route = Customroute::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->post(route('grouphikes.store'), [
            'name' => 'New Group Hike',
            'start_point_name' => 'Start',
            'end_point_name' => 'End',
            'location' => 'Somewhere',
            'date' => now()->addDays(3)->format('Y-m-d'),
            'gatheringtime' => '09:00',
            'starttime' => '09:30',
            'public' => 1,
            'customroute_id' => $route->id,
            'user_id' => $user->id,
            'description' => 'Nice walk in the woods',
            'password' => '',
            'maxparticipants' => 10
        ]);

        $response->assertRedirect(route('grouphikes.mygrouphikes'));
        $this->assertDatabaseHas('grouphikes', ['name' => 'New Group Hike']);
    }

    public function test_join_fails_if_max_participants_reached()
    {
        $grouphike = Grouphike::factory()->create(['maxparticipants' => 1]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);
        $this->post(route('grouphikes.join'), [
            'grouphike_id' => $grouphike->id,
            'user_id' => $user1->id
        ]);

        $this->actingAs($user2);
        $response = $this->post(route('grouphikes.join'), [
            'grouphike_id' => $grouphike->id,
            'user_id' => $user2->id
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('grouphike_participants', [
            'grouphike_id' => $grouphike->id,
            'user_id' => $user2->id
        ]);
    }

    public function test_join_private_hike_fails_with_wrong_password()
    {
        $organizer = User::factory()->create(['email' => 'test@example.com']);
        Grouphike::factory()->create([
            'user_id' => $organizer->id,
            'public' => 0,
            'password' => Hash::make('secret123')
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('grouphikes.join_private_hike'))
            ->post(route('grouphikes.join_private_hike_store'), [
                'email' => 'test@example.com',
                'password' => 'wrongpass'
            ]);

        $response->assertSessionHasErrors('join');
    }

    public function test_update_changes_grouphike_details()
    {
        $user = User::factory()->create();
        $route = Customroute::factory()->create(['user_id' => $user->id]);
        $grouphike = Grouphike::factory()->create(['user_id' => $user->id, 'customroute_id' => $route->id]);

        $this->actingAs($user);

        $response = $this->put(route('grouphikes.update', $grouphike), [
            'name' => 'Updated Hike Name',
            'start_point_name' => $grouphike->start_point_name,
            'end_point_name' => $grouphike->end_point_name,
            'location' => $grouphike->location,
            'date' => $grouphike->date,
            'gatheringtime' => $grouphike->gatheringtime,
            'starttime' => $grouphike->starttime,
            'public' => $grouphike->public,
            'description' => $grouphike->description,
            'customroute_id' => $route->id,
            'user_id' => $user->id,
            'password' => '',
            'maxparticipants' => $grouphike->maxparticipants
        ]);

        $response->assertRedirect(route('grouphikes.mygrouphikes'));
        $this->assertDatabaseHas('grouphikes', ['id' => $grouphike->id, 'name' => 'Updated Hike Name']);
    }

    public function test_destroy_deletes_grouphike()
    {
        $user = User::factory()->create();
        $grouphike = Grouphike::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete(route('grouphikes.destroy', $grouphike));

        $response->assertRedirect(route('grouphikes.mygrouphikes'));
        $this->assertDatabaseMissing('grouphikes', ['id' => $grouphike->id]);
    }
}
