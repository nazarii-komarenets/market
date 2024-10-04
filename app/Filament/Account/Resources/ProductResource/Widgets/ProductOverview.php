<?php

namespace App\Filament\Account\Resources\ProductResource\Widgets;

use App\Http\Repositories\UserRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всього товарів',  app(UserRepository::class)->getProductCount()),
        ];
    }
}
