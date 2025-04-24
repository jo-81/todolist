<?php

namespace App\Enum;

enum Priority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGHT = 'hight';

    public function getIcon(): string
    {
        return match ($this) {
            self::LOW => 'tabler:letter-l',
            self::MEDIUM => 'tabler:letter-m',
            self::HIGHT => 'tabler:letter-h',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGHT => 'danger',
        };
    }
}
