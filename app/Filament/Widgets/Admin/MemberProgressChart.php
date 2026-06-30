<?php

namespace App\Filament\Widgets\Admin;

use App\Models\WorkoutSession;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MemberProgressChart extends ChartWidget
{
    protected ?string $heading = 'Workout Sessions (Last 7 Days)';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $user = auth()->user();

        $sessionsQuery = WorkoutSession::query()
            ->selectRaw('DATE(date) as date, COUNT(*) as count')
            ->where('date', '>=', now()->subDays(7))
            ->groupBy('date');

        if ($user->isTrainer()) {
            $sessionsQuery->whereHas('user.assignedTrainers', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $sessions = $sessionsQuery->get();

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $data[] = $sessions->where('date', $date)->first()?->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Workout Sessions',
                    'data' => $data,
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 107, 53, 0.12)',
                    'borderColor' => '#FF6B35',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
