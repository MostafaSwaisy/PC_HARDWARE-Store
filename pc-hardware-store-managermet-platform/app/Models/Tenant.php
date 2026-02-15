<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;

    protected $fillable = [
        'id',
        'name',
        'subdomain',
        'custom_domain',
        'database_name',
        'status',
        'data',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'subdomain',
            'custom_domain',
            'database_name',
            'status',
            'created_at',
            'updated_at',
        ];
    }
}
