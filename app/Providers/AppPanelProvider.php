<?php

namespace App\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->brandName('REP<span style="color:#10b981;">T</span>RACK')
            ->colors([
                'primary' => Color::hex('#10b981'),
                'gray' => [
                    50  => '#FAFAF9',
                    100 => '#F5F2EB',
                    200 => '#E5E0D5',
                    300 => '#D1CAB8',
                    400 => '#A89F8C',
                    500 => '#8A8174',
                    600 => '#6B635A',
                    700 => '#4A433E',
                    800 => '#2C2C2A',
                    900 => '#1A1A1A',
                    950 => '#0D0D0D',
                ],
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Red,
            ])
            ->viteTheme('resources/css/filament.css')
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
