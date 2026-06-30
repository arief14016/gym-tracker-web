<?php

namespace App\Filament\Resources\Admin\WorkoutPlanResource\Pages;

use App\Filament\Resources\Admin\WorkoutPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutPlans extends ListRecords
{
    protected static string $resource = WorkoutPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
