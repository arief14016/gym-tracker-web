<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\WorkoutSession;
use App\Models\WorkoutSetLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutSetLogFactory extends Factory
{
    protected $model = WorkoutSetLog::class;

    public function definition(): array
    {
        return [
            'workout_session_id' => WorkoutSession::factory(),
            'exercise_id' => Exercise::factory(),
            'set_number' => $this->faker->numberBetween(1, 5),
            'reps' => $this->faker->numberBetween(5, 15),
            'weight' => $this->faker->randomFloat(2, 10, 100),
            'rpe' => $this->faker->optional()->randomFloat(1, 6, 10),
        ];
    }
}
