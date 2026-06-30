<?php

namespace App\Observers;

use App\Models\WorkoutSetLog;
use App\Models\PersonalRecord;
use Illuminate\Support\Facades\DB;

class WorkoutSetLogObserver
{
    /**
     * Calculate the "strength score" for comparison.
     * Using weight * reps as the primary metric.
     */
    protected function calculateStrengthScore(float $weight, int $reps): float
    {
        return $weight * $reps;
    }

    /**
     * Check if this set log represents a new personal record.
     */
    protected function isNewPR(WorkoutSetLog $setLog): bool
    {
        $userId = $setLog->workoutSession->user_id;
        $exerciseId = $setLog->exercise_id;
        $currentScore = $this->calculateStrengthScore($setLog->weight, $setLog->reps);

        // Get the current PR for this exercise
        $currentPR = PersonalRecord::where('user_id', $userId)
            ->where('exercise_id', $exerciseId)
            ->first();

        // If no PR exists, this is definitely a PR
        if (!$currentPR) {
            return true;
        }

        // Compare strength scores
        $currentPRScore = $this->calculateStrengthScore($currentPR->weight, $currentPR->reps);

        return $currentScore > $currentPRScore;
    }

    /**
     * Handle the WorkoutSetLog "created" event.
     */
    public function created(WorkoutSetLog $setLog): void
    {
        if ($this->isNewPR($setLog)) {
            $this->updatePR($setLog);
        }
    }

    /**
     * Handle the WorkoutSetLog "updated" event.
     */
    public function updated(WorkoutSetLog $setLog): void
    {
        // Only check for PR if weight or reps changed
        if ($setLog->wasChanged(['weight', 'reps'])) {
            if ($this->isNewPR($setLog)) {
                $this->updatePR($setLog);
            }
        }
    }

    /**
     * Update or create the personal record.
     */
    protected function updatePR(WorkoutSetLog $setLog): void
    {
        $session = $setLog->workoutSession;

        PersonalRecord::updateOrCreate(
            [
                'user_id' => $session->user_id,
                'exercise_id' => $setLog->exercise_id,
            ],
            [
                'weight' => $setLog->weight,
                'reps' => $setLog->reps,
                'achieved_at' => $session->date,
            ]
        );
    }
}
