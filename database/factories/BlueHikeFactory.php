<?php

namespace Database\Factories;

use App\Models\Hike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlueHike>
 */
class BlueHikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCustomStart = $this->faker->boolean();
        $isCustomEnd = $this->faker->boolean();

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'hike_id' => Hike::factory(),
            'distance' => $this->faker->randomFloat(2, 1, 100),
            'isCustomStart' => $isCustomStart,
            'start_point' => $isCustomStart
                ? $this->faker->numberBetween(1000, 9999) // simulate a custom ID
                : $this->faker->numberBetween(1, 500),
            'isCustomEnd' => $isCustomEnd,
            'end_point' => $isCustomEnd
                ? $this->faker->numberBetween(1000, 9999)
                : $this->faker->numberBetween(1, 500),
            'completed' => $this->faker->boolean(),
            'date' => $this->faker->date(),
            'diary' => $this->faker->sentence(),
        ];
    }
}
