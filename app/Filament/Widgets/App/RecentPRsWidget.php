<?php

namespace App\Filament\Widgets\App;

use App\Models\PersonalRecord;
use Filament\Widgets\TableWidget;
use Filament\Tables;

class RecentPRsWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Personal Records';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return PersonalRecord::query()
            ->where('user_id', auth()->id())
            ->with('exercise')
            ->latest('achieved_at')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('exercise.name')
                ->label('Exercise')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('weight')
                ->label('Weight')
                ->suffix(' kg')
                ->sortable(),
            Tables\Columns\TextColumn::make('reps')
                ->label('Reps')
                ->sortable(),
            Tables\Columns\TextColumn::make('achieved_at')
                ->date()
                ->sortable(),
        ];
    }
}
