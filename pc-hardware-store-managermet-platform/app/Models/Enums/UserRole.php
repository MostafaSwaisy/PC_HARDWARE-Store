<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case TenantOwner = 'tenant_owner';
    case TenantUser = 'tenant_user';
    
public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
