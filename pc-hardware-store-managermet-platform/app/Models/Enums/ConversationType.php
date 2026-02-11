<?php

namespace App\Enums;

enum ConversationType: string
{
    case ProductInquiry = 'product_inquiry';
    case BuildHelp = 'build_help';
    case OrderSupport = 'order_support';
    
    public static function values(): array
    {
        return array_map(fn($type) => $type->value, self::cases());
    }
}
