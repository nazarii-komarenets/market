<?php

namespace App\Traits\Badges;

use App\Models\Product;

trait HasProductBadges
{
    public static function getProductState(Product $record): array
    {
        return [
            $record->game?->title,
            $record->product_type?->title
        ];
    }
}
