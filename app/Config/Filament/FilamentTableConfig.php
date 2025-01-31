<?php
namespace App\Config\Filament;

use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;

class FilamentTableConfig
{
    public static function configure(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table
                ->filtersLayout(FiltersLayout::AboveContentCollapsible)
                ->paginationPageOptions([10, 25, 50]);
        });
    }
}
