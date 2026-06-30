<?php

namespace App\Filament\Widgets\App;

use App\Models\PersonalRecord;
use App\Models\WorkoutSession;
use App\Models\BodyMetric;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        $prCount = PersonalRecord::where('user_id', $userId)->count();

        $sessionCount = WorkoutSession::where('user_id', $userId)
            ->where('date', '>=', now()->startOfMonth())
            ->count();

        $latestMetric = BodyMetric::where('user_id', $userId)
            ->latest('date')
            ->first();

        $weight = $latestMetric?->weight ?? '-';

        return [
            Stat::make('Personal Records', $prCount)
                ->description('Total PRs achieved')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Sessions This Month', $sessionCount)
                ->description('Workout sessions')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('info'),
            Stat::make('Current Weight', $weight . ' kg')
                ->description($latestMetric ? 'Last recorded' : 'No data')
                ->descriptionIcon('heroicon-m-scale')
                ->color('success'),
        ];
    }
}
