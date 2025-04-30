<?php

namespace Database\Factories;

use App\Models\Hike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hike>
 */
class HikeFactory extends Factory
{
    protected $model = Hike::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'distance' => $this->faker->randomFloat(2, 1, 50), 
        ];
    }
}
