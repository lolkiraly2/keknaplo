<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Customroute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grouphike>
 */
class GrouphikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'start_point_name' => $this->faker->city(),
            'end_point_name' => $this->faker->city(),
            'location' => $this->faker->state(),
            'date' => $this->faker->date(),
            'gatheringtime' => $this->faker->time('H:i'),
            'starttime' => $this->faker->time('H:i'),
            'public' => $this->faker->boolean(70),
            'password' => $this->faker->optional(0.3)->password(),
            'maxparticipants' => $this->faker->numberBetween(5, 50),
            'user_id' => User::factory(),
            'customroute_id' => Customroute::factory(),
            'description' => $this->faker->paragraph(3),
        ];
    }
}
