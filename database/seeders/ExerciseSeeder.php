<?php

namespace Database\Seeders;

use App\Enums\MuscleGroup;
use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            // Chest
            ['name' => 'Barbell Bench Press', 'muscle_group' => MuscleGroup::Chest, 'description' => 'Classic chest exercise using barbell'],
            ['name' => 'Incline Dumbbell Press', 'muscle_group' => MuscleGroup::Chest, 'description' => 'Upper chest focused dumbbell press'],
            ['name' => 'Cable Fly', 'muscle_group' => MuscleGroup::Chest, 'description' => 'Isolation exercise for chest'],
            ['name' => 'Push-ups', 'muscle_group' => MuscleGroup::Chest, 'description' => 'Bodyweight chest exercise'],
            ['name' => 'Dumbbell Fly', 'muscle_group' => MuscleGroup::Chest, 'description' => 'Chest isolation exercise'],

            // Back
            ['name' => 'Deadlift', 'muscle_group' => MuscleGroup::Back, 'description' => 'Compound exercise for back and legs'],
            ['name' => 'Barbell Row', 'muscle_group' => MuscleGroup::Back, 'description' => 'Bent-over row with barbell'],
            ['name' => 'Lat Pulldown', 'muscle_group' => MuscleGroup::Back, 'description' => 'Machine exercise for lats'],
            ['name' => 'Pull-ups', 'muscle_group' => MuscleGroup::Back, 'description' => 'Bodyweight back exercise'],
            ['name' => 'Seated Cable Row', 'muscle_group' => MuscleGroup::Back, 'description' => 'Cable exercise for back thickness'],

            // Shoulders
            ['name' => 'Overhead Press', 'muscle_group' => MuscleGroup::Shoulders, 'description' => 'Standing shoulder press with barbell'],
            ['name' => 'Lateral Raise', 'muscle_group' => MuscleGroup::Shoulders, 'description' => 'Isolation for side delts'],
            ['name' => 'Front Raise', 'muscle_group' => MuscleGroup::Shoulders, 'description' => 'Isolation for front delts'],
            ['name' => 'Face Pull', 'muscle_group' => MuscleGroup::Shoulders, 'description' => 'Rear delt and rotator cuff exercise'],
            ['name' => 'Arnold Press', 'muscle_group' => MuscleGroup::Shoulders, 'description' => 'Dumbbell shoulder press variation'],

            // Biceps
            ['name' => 'Barbell Curl', 'muscle_group' => MuscleGroup::Biceps, 'description' => 'Classic bicep exercise'],
            ['name' => 'Dumbbell Curl', 'muscle_group' => MuscleGroup::Biceps, 'description' => 'Standing dumbbell curl'],
            ['name' => 'Hammer Curl', 'muscle_group' => MuscleGroup::Biceps, 'description' => 'Neutral grip curl for biceps and forearms'],
            ['name' => 'Preacher Curl', 'muscle_group' => MuscleGroup::Biceps, 'description' => 'Isolated bicep curl on preacher bench'],
            ['name' => 'Concentration Curl', 'muscle_group' => MuscleGroup::Biceps, 'description' => 'Single-arm isolated bicep curl'],

            // Triceps
            ['name' => 'Tricep Pushdown', 'muscle_group' => MuscleGroup::Triceps, 'description' => 'Cable exercise for triceps'],
            ['name' => 'Skull Crushers', 'muscle_group' => MuscleGroup::Triceps, 'description' => 'Lying tricep extension'],
            ['name' => 'Close Grip Bench Press', 'muscle_group' => MuscleGroup::Triceps, 'description' => 'Bench press variation for triceps'],
            ['name' => 'Tricep Dips', 'muscle_group' => MuscleGroup::Triceps, 'description' => 'Bodyweight tricep exercise'],
            ['name' => 'Overhead Tricep Extension', 'muscle_group' => MuscleGroup::Triceps, 'description' => 'Dumbbell extension for long head'],

            // Quadriceps
            ['name' => 'Barbell Squat', 'muscle_group' => MuscleGroup::Quadriceps, 'description' => 'Compound leg exercise'],
            ['name' => 'Leg Press', 'muscle_group' => MuscleGroup::Quadriceps, 'description' => 'Machine leg exercise'],
            ['name' => 'Leg Extension', 'muscle_group' => MuscleGroup::Quadriceps, 'description' => 'Isolation for quadriceps'],
            ['name' => 'Lunges', 'muscle_group' => MuscleGroup::Quadriceps, 'description' => 'Single-leg exercise for quads'],
            ['name' => 'Hack Squat', 'muscle_group' => MuscleGroup::Quadriceps, 'description' => 'Machine squat variation'],

            // Hamstrings
            ['name' => 'Romanian Deadlift', 'muscle_group' => MuscleGroup::Hamstrings, 'description' => 'Hip hinge for hamstrings'],
            ['name' => 'Leg Curl', 'muscle_group' => MuscleGroup::Hamstrings, 'description' => 'Isolation for hamstrings'],
            ['name' => 'Stiff Leg Deadlift', 'muscle_group' => MuscleGroup::Hamstrings, 'description' => 'Deadlift variation for hamstrings'],
            ['name' => 'Good Mornings', 'muscle_group' => MuscleGroup::Hamstrings, 'description' => 'Hip hinge with barbell'],

            // Glutes
            ['name' => 'Hip Thrust', 'muscle_group' => MuscleGroup::Glutes, 'description' => 'Primary glute exercise'],
            ['name' => 'Glute Bridge', 'muscle_group' => MuscleGroup::Glutes, 'description' => 'Bodyweight glute exercise'],
            ['name' => 'Cable Kickback', 'muscle_group' => MuscleGroup::Glutes, 'description' => 'Isolation for glutes'],
            ['name' => 'Sumo Deadlift', 'muscle_group' => MuscleGroup::Glutes, 'description' => 'Wide stance deadlift variation'],

            // Calves
            ['name' => 'Standing Calf Raise', 'muscle_group' => MuscleGroup::Calves, 'description' => 'Primary calf exercise'],
            ['name' => 'Seated Calf Raise', 'muscle_group' => MuscleGroup::Calves, 'description' => 'Seated calf exercise'],

            // Core
            ['name' => 'Plank', 'muscle_group' => MuscleGroup::Core, 'description' => 'Isometric core exercise'],
            ['name' => 'Hanging Leg Raise', 'muscle_group' => MuscleGroup::Core, 'description' => 'Lower ab exercise'],
            ['name' => 'Cable Crunch', 'muscle_group' => MuscleGroup::Core, 'description' => 'Weighted ab exercise'],
            ['name' => 'Russian Twist', 'muscle_group' => MuscleGroup::Core, 'description' => 'Oblique exercise'],
            ['name' => 'Ab Wheel Rollout', 'muscle_group' => MuscleGroup::Core, 'description' => 'Advanced core exercise'],

            // Cardio
            ['name' => 'Treadmill Running', 'muscle_group' => MuscleGroup::Cardio, 'description' => 'Cardiovascular exercise'],
            ['name' => 'Cycling', 'muscle_group' => MuscleGroup::Cardio, 'description' => 'Low-impact cardio'],
            ['name' => 'Rowing Machine', 'muscle_group' => MuscleGroup::Cardio, 'description' => 'Full body cardio'],
            ['name' => 'Jump Rope', 'muscle_group' => MuscleGroup::Cardio, 'description' => 'High-intensity cardio'],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}
