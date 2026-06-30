<?php

namespace App\Providers;

use Filament\Panel;
use Filament\PanelProvider;
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
            ->path($adminPath)
            ->login()
            ->colors([
                'primary' => '#3b82f6',
            ])
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
