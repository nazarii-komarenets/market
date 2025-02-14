<?php
namespace App\Enums;

enum DeliveryOptionEnum: string
{
    case NOVA_POST = 'Нова Пошта';
    case UKR_POST = 'Укр. Пошта';
    case MEEST = 'Meest';

    public static function getLabel(string $key): ?string
    {
        return match ($key) {
            'nova_post' => self::NOVA_POST->value,
            'ukr_post' => self::UKR_POST->value,
            'meest' => self::MEEST->value,
            default => null,
        };
    }
}
