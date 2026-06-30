<?php

namespace App\Enums;

enum MuscleGroup: string
{
    case Chest = 'chest';
    case Back = 'back';
    case Shoulders = 'shoulders';
    case Biceps = 'biceps';
    case Triceps = 'triceps';
    case Forearms = 'forearms';
    case Core = 'core';
    case Quadriceps = 'quadriceps';
    case Hamstrings = 'hamstrings';
    case Glutes = 'glutes';
    case Calves = 'calves';
    case FullBody = 'full_body';
    case Cardio = 'cardio';

    public function label(): string
    {
        return match($this) {
            self::Chest => 'Chest',
            self::Back => 'Back',
            self::Shoulders => 'Shoulders',
            self::Biceps => 'Biceps',
            self::Triceps => 'Triceps',
            self::Forearms => 'Forearms',
            self::Core => 'Core',
            self::Quadriceps => 'Quadriceps',
            self::Hamstrings => 'Hamstrings',
            self::Glutes => 'Glutes',
            self::Calves => 'Calves',
            self::FullBody => 'Full Body',
            self::Cardio => 'Cardio',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
