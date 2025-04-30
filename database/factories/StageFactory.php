<?php

namespace Database\Factories;

use App\Models\Hike;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
{
    protected $model = Stage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->regexify('(OKT|DDK|AK)[ ]?[A-Z]{1,3}[0-9]{1,2}'),
            'hike_id' => Hike::factory(),
        ];
    }
}
