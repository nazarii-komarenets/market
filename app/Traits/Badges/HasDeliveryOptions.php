<?php

namespace App\Traits\Badges;

use App\Enums\DeliveryOptionEnum;
use App\Models\User;

trait HasDeliveryOptions
{
    public static function getDeliveryOptions(User $user): array
    {
        $options = $user->delivery_options;

        if (!$options) {
            return [];
        }

        return collect([
            'nova_post' => $options->nova_post,
            'ukr_post' => $options->ukr_post,
            'meest' => $options->meest,
        ])
            ->filter()
            ->keys()
            ->map(fn ($key) => DeliveryOptionEnum::getLabel($key))
            ->toArray();
    }
}
