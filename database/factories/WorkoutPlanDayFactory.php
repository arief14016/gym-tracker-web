<?php

namespace Database\Factories;

use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanDay;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutPlanDayFactory extends Factory
{
    protected $model = WorkoutPlanDay::class;

    public function definition(): array
    {
        return [
            'workout_plan_id' => WorkoutPlan::factory(),
            'day_order' => $this->faker->numberBetween(1, 7),
            'name' => $this->faker->randomElement(['Push Day', 'Pull Day', 'Leg Day', 'Upper Body', 'Lower Body', 'Rest Day', 'Cardio Day']),
        ];
    }
}
