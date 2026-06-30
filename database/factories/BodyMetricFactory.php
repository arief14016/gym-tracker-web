<?php

namespace Database\Factories;

use App\Models\BodyMetric;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BodyMetricFactory extends Factory
{
    protected $model = BodyMetric::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recorded_by' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'weight' => $this->faker->randomFloat(2, 50, 100),
            'height' => $this->faker->optional()->randomFloat(2, 150, 190),
            'body_fat_percentage' => $this->faker->optional()->randomFloat(2, 10, 30),
            'progress_photo' => null,
        ];
    }
}
