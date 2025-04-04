<?php

namespace App\Enum;

enum MembershipLevel: string
{
    case VIP = 'vip';
    case PREMIUM = 'premium';
    case REGISTER = 'register';
}
