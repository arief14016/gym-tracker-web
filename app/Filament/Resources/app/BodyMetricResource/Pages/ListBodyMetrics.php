<?php

namespace App\Filament\Resources\App\BodyMetricResource\Pages;

use App\Filament\Resources\App\BodyMetricResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBodyMetrics extends ListRecords
{
    protected static string $resource = BodyMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
