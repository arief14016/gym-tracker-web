<?php

namespace App\Filament\Widgets\Admin;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\WorkoutSession;
use App\Models\WorkoutPlan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $query = User::query();

        // Trainers see their assigned members count
        if ($user->isTrainer()) {
            $memberCount = $user->assignedMembers()->count();
        } else {
            $memberCount = User::where('role', UserRole::Member)->count();
        }

        $sessionCount = WorkoutSession::when($user->isTrainer(), function ($query) use ($user) {
            $query->whereHas('user.assignedTrainers', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        })->count();

        $planCount = WorkoutPlan::when($user->isTrainer(), function ($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();

        return [
            Stat::make('Total Members', $memberCount)
                ->description('Active gym members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Workout Sessions', $sessionCount)
                ->description('This month')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('info'),
            Stat::make('Workout Plans', $planCount)
                ->description('Active plans')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
        ];
    }
}
