<?php

namespace App\Http\Controllers\Api;

use App\Enums\TenantStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTenantRequest;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class TenantOnboardingController extends Controller
{
    public function store(StoreTenantRequest $request): JsonResponse
    {
        $tenantId = (string) Str::uuid();
        $subdomain = $request->string('subdomain')->toString();

        $tenant = Tenant::create([
            'id' => $tenantId,
            'name' => $request->string('name')->toString(),
            'subdomain' => $subdomain,
            'custom_domain' => $request->input('custom_domain'),
            'database_name' => 'tenant'.$tenantId,
            'status' => TenantStatus::Active->value,
        ]);

        $tenant->domains()->create([
            'domain' => $subdomain.'.localhost',
        ]);

        return response()->json([
            'message' => 'Tenant created and provisioning started.',
            'tenant' => [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'subdomain' => $tenant->subdomain,
                'status' => $tenant->status,
                'domain' => $tenant->domains()->first()?->domain,
            ],
        ], Response::HTTP_CREATED);
    }

    public function readiness(Tenant $tenant, Tenancy $tenancy): JsonResponse
    {
        $checks = [
            'database_connection' => false,
            'categories_table' => false,
            'suppliers_table' => false,
            'products_table' => false,
            'seeded_categories' => false,
            'seeded_suppliers' => false,
        ];

        $error = null;

        try {
            $tenancy->initialize($tenant);

            $checks['database_connection'] = true;
            $checks['categories_table'] = Schema::hasTable('categories');
            $checks['suppliers_table'] = Schema::hasTable('suppliers');
            $checks['products_table'] = Schema::hasTable('products');
            $checks['seeded_categories'] = Category::query()->exists();
            $checks['seeded_suppliers'] = Supplier::query()->exists();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
        } finally {
            $tenancy->end();
        }

        $isReady = ! in_array(false, $checks, true);

        return response()->json([
            'tenant' => [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'subdomain' => $tenant->subdomain,
                'domain' => $tenant->domains()->first()?->domain,
                'status' => $tenant->status,
            ],
            'is_ready' => $isReady,
            'checks' => $checks,
            'error' => $error,
        ]);
    }
}
