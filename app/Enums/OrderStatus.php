<?php
namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Shipped = 'shipped';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Очікування',
            self::Shipped => 'Доставлено',
            self::Completed => 'Виконано',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Shipped => 'info',
            self::Completed => 'success',
        };
    }
}
