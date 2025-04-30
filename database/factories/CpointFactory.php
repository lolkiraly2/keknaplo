<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Stage;
use App\Models\Cpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cpoint>
 */
class CpointFactory extends Factory
{
    protected $model = Cpoint::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'stage_id' => Stage::factory(),
            'lat' => $this->faker->latitude(45, 49),
            'lon' => $this->faker->longitude(16, 23),
            'description' => $this->faker->optional()->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
