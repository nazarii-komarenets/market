<?php

namespace App\Providers;

use App\Config\Filament\FilamentTableConfig;
use App\Models\Order;
use App\Observers\OrderObserver;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
        FilamentTableConfig::configure();
        DatabaseNotifications::trigger('filament.notifications.database-notifications-trigger');
    }
}
