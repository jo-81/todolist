<?php

namespace App\Enum;

enum MembershipLevel: string
{
    case VIP = 'vip';
    case PREMIUM = 'premium';
    case REGISTER = 'register';

    public function getWorkspaceLimit(): int
    {
        return match ($this) {
            self::VIP => -1,
            self::PREMIUM => 2,
            self::REGISTER => 1,
        };
    }

    public function getProjectLimit(): int
    {
        return match ($this) {
            self::VIP => -1,
            self::PREMIUM => 10,
            self::REGISTER => 5,
        };
    }
}
