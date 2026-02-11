<?php

namespace App\Enums;

enum PcBuildStatus: string
{
    case Draft = 'draft';
    case CompatibilityChecked = 'compatibility_checked';
    case Quoted = 'quoted';
    case Ordered = 'ordered';
    
      public static function values(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }
}