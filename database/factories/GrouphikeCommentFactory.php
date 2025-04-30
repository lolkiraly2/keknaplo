<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Grouphike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrouphikeComment>
 */
class GrouphikeCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'grouphike_id' => Grouphike::factory(),
            'comment' => $this->faker->paragraph(2),
        ];
    }
}
