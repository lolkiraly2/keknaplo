<?php

namespace Database\Factories;

use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stamp>
 */
class StampFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mtsz_id' => $this->faker->unique()->bothify('MTSZ-####'),
            'stamp_id' => $this->faker->unique()->bothify('STAMP-####'),
            'stage_id' => Stage::factory(),
            'name' => $this->faker->words(3, true),
            'location' => $this->faker->city(),
            'location_description' => $this->faker->sentence(),
            'address' => $this->faker->address(),
            'availability' => $this->faker->randomElement(['Folyamatos', 'Nyitvatartás szerint']),
            'opening_hours' => $this->faker->regexify('[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}'),
            'lat' => $this->faker->latitude(45, 49),
            'lon' => $this->faker->longitude(16, 23),
            'stamp_url' => $this->faker->imageUrl(640, 480, 'stamps', true),
            'picture1_url' => $this->faker->imageUrl(640, 480, 'places', true),
            'picture2_url' => $this->faker->optional()->imageUrl(640, 480, 'nature', true),
            'picture3_url' => $this->faker->optional()->imageUrl(640, 480, 'travel', true),
        ];
    }
}
