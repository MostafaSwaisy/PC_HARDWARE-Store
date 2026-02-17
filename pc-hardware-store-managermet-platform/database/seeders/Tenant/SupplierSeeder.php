<?php

namespace Database\Seeders\Tenant;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $suppliers = [
            [
                'name' => 'Local Tech Distributor',
                'contact_person' => 'Sales Team',
                'email' => 'sales@local-tech.example',
                'phone' => '+970-59-100-0001',
                'address' => 'Gaza, Palestine',
                'payment_terms' => 'Net 15',
                'average_delivery_days' => 3,
                'rating' => 4.50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'MENA Components Hub',
                'contact_person' => 'Wholesale Desk',
                'email' => 'wholesale@mena-components.example',
                'phone' => '+962-79-100-0002',
                'address' => 'Amman, Jordan',
                'payment_terms' => 'Net 30',
                'average_delivery_days' => 7,
                'rating' => 4.20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Global PC Parts',
                'contact_person' => 'Account Manager',
                'email' => 'account@global-parts.example',
                'phone' => '+971-50-100-0003',
                'address' => 'Dubai, UAE',
                'payment_terms' => 'Prepaid',
                'average_delivery_days' => 10,
                'rating' => 4.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Supplier::query()->upsert($suppliers, ['email'], ['updated_at', 'name', 'contact_person', 'phone', 'address', 'payment_terms', 'average_delivery_days', 'rating']);
    }
}
