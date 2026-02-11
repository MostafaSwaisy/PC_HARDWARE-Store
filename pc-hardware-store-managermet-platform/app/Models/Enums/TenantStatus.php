<?php

namespace App\Enums;

enum TenantStatus: string
{
    case Active = 'active';
    case Suspended = 'suspended';
    case Cancelled = 'cancelled';
    
public static function values(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }
}
