<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StampComment>
 */
class StampCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state' => $this->faker->randomElement(['Rendben', 'Sérült', 'Hiányzik']),
            'user_id' => User::factory(),
            'stamp_mtsz_id' => $this->faker->regexify('MTSZ-[0-9]{3,4}'),
            'detection' => $this->faker->date(),
            'comment' => $this->faker->paragraph(),
        ];
    }
}
