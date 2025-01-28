<?php
namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use App\Enums\OrderStatus;

class StatusColumn extends TextColumn
{
    protected static function getStateValue($state): string
    {
        $status = OrderStatus::tryFrom($state);

        if ($status) {
            return "<span class='badge badge-{$status->badgeClass()}'>{$status->label()}</span>";
        }

        return $state;
    }

    public static function make($name = null): static
    {
        return parent::make($name)
            ->formatStateUsing(fn ($state) => self::getStateValue($state))
            ->badge()
            ->color(fn ($state) => OrderStatus::tryFrom($state)?->badgeClass())
            ->html();
    }
}
