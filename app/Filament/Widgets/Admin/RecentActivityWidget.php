<?php

namespace App\Filament\Widgets\Admin;

use App\Models\WorkoutSession;
use Filament\Widgets\TableWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class RecentActivityWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Workout Sessions';

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        $query = WorkoutSession::query()
            ->with(['user', 'workoutPlanDay.workoutPlan'])
            ->latest('date')
            ->limit(10);

        if ($user->isTrainer()) {
            $query->whereHas('user.assignedTrainers', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')
                ->label('Member')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('workoutPlanDay.name')
                ->label('Day'),
            Tables\Columns\TextColumn::make('duration')
                ->label('Duration')
                ->suffix(' min'),
            Tables\Columns\TextColumn::make('setLogs_count')
                ->label('Sets')
                ->getStateUsing(fn ($record) => $record->setLogs()->count()),
        ];
    }
}
