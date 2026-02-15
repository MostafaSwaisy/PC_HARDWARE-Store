<?php

namespace App\Enums;

enum ConversationStatus: string
{
    case Active = 'active';
    case Resolved = 'resolved';

    public static function values(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
