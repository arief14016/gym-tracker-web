<?php

namespace App\Filament\Widgets\App;

use App\Models\BodyMetric;
use Filament\Widgets\ChartWidget;

class BodyMetricsChart extends ChartWidget
{
    protected ?string $heading = 'Weight Progress (Last 30 Days)';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $userId = auth()->id();

        $metrics = BodyMetric::where('user_id', $userId)
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Weight (kg)',
                    'data' => $metrics->pluck('weight')->toArray(),
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 107, 53, 0.12)',
                    'borderColor' => '#FF6B35',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $metrics->pluck('date')->map(fn ($date) => $date->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
