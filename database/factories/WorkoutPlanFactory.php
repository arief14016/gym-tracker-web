<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutPlanFactory extends Factory
{
    protected $model = WorkoutPlan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'created_by' => User::factory(),
            'name' => $this->faker->words(3, true) . ' Plan',
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
