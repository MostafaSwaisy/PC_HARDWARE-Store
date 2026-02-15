<?php

namespace App\Enums;

enum CustomerTypes: string
{
    case WalkIn = 'walk_in';
    case Online = 'online';
    case Wholesale = 'wholesale';

    public static function values(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
