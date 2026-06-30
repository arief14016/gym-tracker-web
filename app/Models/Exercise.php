<?php

namespace App\Models;

use App\Enums\MuscleGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'muscle_group',
        'description',
        'video_url',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'muscle_group' => MuscleGroup::class,
        ];
    }

    public function workoutPlanExercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class);
    }

    public function workoutSetLogs(): HasMany
    {
        return $this->hasMany(WorkoutSetLog::class);
    }

    public function personalRecords(): HasMany
    {
        return $this->hasMany(PersonalRecord::class);
    }
}
