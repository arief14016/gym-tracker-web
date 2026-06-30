<?php

namespace App\Filament\Resources\App;

use App\Filament\Resources\App\BodyMetricResource\Pages;
use App\Models\BodyMetric;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Actions\DeleteAction;

class BodyMetricResource extends Resource
{
    protected static ?string $model = BodyMetric::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Health';
    }

    public static function getModelLabel(): string
    {
        return 'Body Metric';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Body Metrics';
    }

    public static function form(Schema $schema): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Measurements')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('weight')
                                    ->label('Weight (kg)')
                                    ->numeric()
                                    ->required()
                                    ->step(0.1),
                                Forms\Components\TextInput::make('height')
                                    ->label('Height (cm)')
                                    ->numeric()
                                    ->step(0.1),
                                Forms\Components\TextInput::make('body_fat_percentage')
                                    ->label('Body Fat %')
                                    ->numeric()
                                    ->step(0.1),
                            ]),
                    ]),
                Forms\Components\Section::make('Progress Photo')
                    ->schema([
                        Forms\Components\FileUpload::make('progress_photo')
                            ->image()
                            ->directory('body-metrics'),
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
                Tables\Columns\TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('height')
                    ->label('Height (cm)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('body_fat_percentage')
                    ->label('Body Fat %')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('progress_photo')
                    ->circular(),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBodyMetrics::route('/'),
            'create' => Pages\CreateBodyMetric::route('/create'),
            'view' => Pages\ViewBodyMetric::route('/{record}'),
            'edit' => Pages\EditBodyMetric::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['recorded_by'] = auth()->id();
        return $data;
    }
}
