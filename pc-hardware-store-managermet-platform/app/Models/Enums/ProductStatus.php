<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Active = 'active';
    case Discontinued = 'discontinued';
    case OutOfStock = 'out_of_stock';

    public static function values(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }
}
