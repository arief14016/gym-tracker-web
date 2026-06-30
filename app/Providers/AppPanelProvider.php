<?php

namespace App\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Widgets\App\MemberStatsWidget;
use App\Filament\Widgets\App\BodyMetricsChart;
use App\Filament\Widgets\App\RecentPRsWidget;
use App\Filament\Widgets\App\WorkoutFrequencyChart;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->login()
            ->colors([
                'primary' => '#10b981',
            ])
            ->discoverResources(in: app_path('Filament/Resources/app'), for: 'App\\Filament\\Resources\\App')
            ->discoverPages(in: app_path('Filament/Pages/app'), for: 'App\\Filament\\Pages\\App')
            ->discoverWidgets(in: app_path('Filament/Widgets/App'), for: 'App\\Filament\\Widgets\\App')
            ->widgets([
                \Filament\Widgets\AccountWidget::class,
                MemberStatsWidget::class,
                BodyMetricsChart::class,
                RecentPRsWidget::class,
                WorkoutFrequencyChart::class,
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            ])
            ->authMiddleware([
                \Illuminate\Auth\Middleware\Authenticate::class,
            ]);
    }
}
