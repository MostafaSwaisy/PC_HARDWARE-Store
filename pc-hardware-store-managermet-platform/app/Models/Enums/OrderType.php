<?php

namespace App\Enums;

enum OrderType: string
{

    case Online = 'online';
    case InStore = 'in_store';
    case CustomBuild = 'custom_build';

    public static function values(): array
    {
        return array_map(fn($type) => $type->value, self::cases());
    }
}
