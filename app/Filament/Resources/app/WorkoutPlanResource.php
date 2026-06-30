<?php

namespace App\Filament\Resources\App;

use App\Filament\Resources\App\WorkoutPlanResource\Pages;
use App\Models\WorkoutPlan;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkoutPlanResource extends Resource
{
    protected static ?string $model = WorkoutPlan::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-calendar';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Workouts';
    }

    public static function getModelLabel(): string
    {
        return 'Workout Plan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Workout Plans';
    }

    
public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Plan Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('days_count')
                    ->label('Days')
                    ->getStateUsing(fn (WorkoutPlan $record) => $record->days()->count()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkoutPlans::route('/'),
            'view' => Pages\ViewWorkoutPlan::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return $record->created_by === auth()->id();
    }

    public static function canDelete($record): bool
    {
        return $record->created_by === auth()->id();
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = auth()->user();

        return parent::getEloquentQuery()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('created_by', $user->id);
            })
            ->where('is_active', true);
    }
}
