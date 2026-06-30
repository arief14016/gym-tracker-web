<?php

namespace App\Filament\Resources\Admin;

use App\Enums\UserRole;
use App\Filament\Resources\Admin\UserManagementResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserManagementResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public static function getModelLabel(): string
    {
        return 'User Management';
    }

    public static function getPluralModelLabel(): string
    {
        return 'User Management';
    }

    public static function form(Schema $schema): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('role')
                            ->required()
                            ->options(UserRole::class)
                            ->disabled(fn () => auth()->user()?->isAdmin() === false),
                    ]),
                Forms\Components\Section::make('Trainer-Member Assignment')
                    ->description('Assign members to this trainer (for trainers only)')
                    ->schema([
                        Forms\Components\Select::make('assigned_members')
                            ->label('Assigned Members')
                            ->multiple()
                            ->relationship('assignedMembers', 'name')
                            ->options(function (callable $get) {
                                return User::where('role', UserRole::Member)
                                    ->pluck('name', 'id');
                            })
                            ->disabled(fn () => $get('role') !== UserRole::Trainer->value),
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
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (UserRole $state): string => match ($state) {
                        UserRole::Admin => 'danger',
                        UserRole::Trainer => 'warning',
                        UserRole::Member => 'success',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedMembers.name')
                    ->label('Assigned Members')
                    ->badge()
                    ->limit(3),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(UserRole::class),
            ])
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
            'index' => Pages\ListUserManagements::route('/'),
            'create' => Pages\CreateUserManagement::route('/create'),
            'view' => Pages\ViewUserManagement::route('/{record}'),
            'edit' => Pages\EditUserManagement::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isAdmin() && auth()->id() !== $record->id;
    }
}
