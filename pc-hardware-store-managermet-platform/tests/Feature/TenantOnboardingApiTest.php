<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TenantOnboardingApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_authenticated_user_can_create_tenant_and_check_readiness(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $create = $this->postJson('/api/v1/tenants', [
            'name' => 'Demo Store',
            'subdomain' => 'demo-store',
        ]);

        $create->assertCreated()
            ->assertJsonPath('tenant.name', 'Demo Store')
            ->assertJsonStructure([
                'message',
                'tenant' => ['id', 'name', 'subdomain', 'status', 'domain'],
            ]);

        $tenantId = $create->json('tenant.id');

        $this->getJson("/api/v1/tenants/{$tenantId}/readiness")
            ->assertOk()
            ->assertJsonPath('is_ready', true)
            ->assertJsonPath('checks.database_connection', true)
            ->assertJsonPath('checks.categories_table', true)
            ->assertJsonPath('checks.suppliers_table', true)
            ->assertJsonPath('checks.products_table', true)
            ->assertJsonPath('checks.seeded_categories', true)
            ->assertJsonPath('checks.seeded_suppliers', true);
    }
}
