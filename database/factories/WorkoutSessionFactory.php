<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkoutSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutSessionFactory extends Factory
{
    protected $model = WorkoutSession::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'workout_plan_day_id' => null,
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'duration' => $this->faker->numberBetween(30, 120),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
