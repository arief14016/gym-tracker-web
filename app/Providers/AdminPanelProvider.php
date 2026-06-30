<?php

namespace App\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\Admin\StatsOverviewWidget;
use App\Filament\Widgets\Admin\MemberProgressChart;
use App\Filament\Widgets\Admin\RecentActivityWidget;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $adminPath = env('FILAMENT_ADMIN_PATH', 'cp-' . substr(md5(config('app.key')), 0, 6));

        return $panel
            ->id('admin')
            ->default()
            ->path($adminPath)
            ->login()
            ->brandName('REP<span style="color:#FF6B35;">T</span>RACK')
            ->colors([
                'primary' => Color::hex('#FF6B35'),
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
            ->discoverResources(in: app_path('Filament/Resources/admin'), for: 'App\\Filament\\Resources\\Admin')
            ->discoverPages(in: app_path('Filament/Pages/admin'), for: 'App\\Filament\\Pages\\Admin')
            ->discoverWidgets(in: app_path('Filament/Widgets/Admin'), for: 'App\\Filament\\Widgets\\Admin')
            ->widgets([
                \Filament\Widgets\AccountWidget::class,
                StatsOverviewWidget::class,
                MemberProgressChart::class,
                RecentActivityWidget::class,
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
