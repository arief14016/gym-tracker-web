<?php

namespace App\Filament\Resources\Admin;

use App\Enums\UserRole;
use App\Filament\Resources\Admin\WorkoutPlanResource\Pages;
use App\Models\User;
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
        return 'Workout Plans';
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
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\Section::make('Plan Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Assignment')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Member')
                            ->required()
                            ->options(function () use ($user) {
                                if ($user->isAdmin()) {
                                    return User::where('role', UserRole::Member)->pluck('name', 'id');
                                }
                                return $user->assignedMembers()->pluck('name', 'id');
                            })
                            ->searchable(),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Member')
                    ->sortable()
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListWorkoutPlans::route('/'),
            'create' => Pages\CreateWorkoutPlan::route('/create'),
            'view' => Pages\ViewWorkoutPlan::route('/{record}'),
            'edit' => Pages\EditWorkoutPlan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()
            ->where('created_by', $user->id)
            ->orWhereHas('user.assignedTrainers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }
}
