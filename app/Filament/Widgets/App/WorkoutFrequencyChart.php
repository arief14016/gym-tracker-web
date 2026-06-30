<?php

namespace App\Filament\Widgets\App;

use App\Models\WorkoutSession;
use Filament\Widgets\ChartWidget;

class WorkoutFrequencyChart extends ChartWidget
{
    protected ?string $heading = 'Workout Frequency (This Month)';

    protected ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $userId = auth()->id();

        $sessions = WorkoutSession::where('user_id', $userId)
            ->where('date', '>=', now()->startOfMonth())
            ->selectRaw('strftime("%w", date) as day, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $data = [];

        foreach ($days as $index => $day) {
            $data[] = $sessions->get((string) $index)?->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sessions',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 107, 53, 0.4)',
                    'borderColor' => '#FF6B35',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $days,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
