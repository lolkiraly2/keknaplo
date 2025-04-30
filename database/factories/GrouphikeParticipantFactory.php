<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Grouphike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrouphikeParticipant>
 */
class GrouphikeParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grouphike_id' => Grouphike::factory(),
            'user_id' => User::factory(),
        ];
    }
}
