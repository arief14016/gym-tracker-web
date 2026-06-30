<?php

namespace App\Filament\Resources\App;

use App\Filament\Resources\App\WorkoutSessionResource\Pages;
use App\Models\WorkoutSession;
use App\Models\WorkoutPlanDay;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkoutSessionResource extends Resource
{
    protected static ?string $model = WorkoutSession::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-play-circle';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Workouts';
    }

    public static function getModelLabel(): string
    {
        return 'Workout Session';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Workout Sessions';
    }

    public static function form(Schema $schema): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Session Details')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('workout_plan_day_id')
                            ->label('Workout Plan Day')
                            ->options(function () {
                                $user = auth()->user();
                                return WorkoutPlanDay::whereHas('workoutPlan', function (Builder $query) use ($user) {
                                    $query->where('user_id', $user->id)
                                        ->orWhere('created_by', $user->id);
                                })->with('workoutPlan')
                                    ->get()
                                    ->mapWithKeys(fn ($day) => [
                                        $day->id => $day->workoutPlan->name . ' - ' . $day->name
                                    ]);
                            })
                            ->searchable()
                            ->preload(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('duration')
                                    ->label('Duration (minutes)')
                                    ->numeric(),
                                Forms\Components\TextInput::make('notes')
                                    ->maxLength(65535),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workoutPlanDay.workoutPlan.name')
                    ->label('Plan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('workoutPlanDay.name')
                    ->label('Day')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration (min)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('setLogs_count')
                    ->label('Sets')
                    ->getStateUsing(fn (WorkoutSession $record) => $record->setLogs()->count()),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(30),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkoutSessions::route('/'),
            'create' => Pages\CreateWorkoutSession::route('/create'),
            'view' => Pages\ViewWorkoutSession::route('/{record}'),
            'edit' => Pages\EditWorkoutSession::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->with(['workoutPlanDay.workoutPlan', 'setLogs']);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
