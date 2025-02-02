<?php

namespace App\Enums;

enum ImprovementRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Очікує',
            self::Approved => 'Схвалено',
            self::Rejected => 'Відхилено',
        };
    }
}
