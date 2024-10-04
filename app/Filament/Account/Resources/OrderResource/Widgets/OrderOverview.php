<?php

namespace App\Filament\Account\Resources\OrderResource\Widgets;

use App\Http\Repositories\UserRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class OrderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всього замовлень',  app(UserRepository::class)->getOrderCount(Auth::id())),

        ];
    }
}
