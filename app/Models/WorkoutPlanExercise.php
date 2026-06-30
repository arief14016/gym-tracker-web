<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutPlanExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_plan_day_id',
        'exercise_id',
        'target_sets',
        'target_reps',
        'target_weight',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'target_weight' => 'decimal:2',
            'target_sets' => 'integer',
            'target_reps' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function workoutPlanDay(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlanDay::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
