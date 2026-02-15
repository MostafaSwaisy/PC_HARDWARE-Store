<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SupplierApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_supplier_crud_and_delete_guard_work_on_tenant_domain(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tenantResponse = $this->postJson('/api/v1/tenants', [
            'name' => 'Supplier Store',
            'subdomain' => 'supplier-store',
        ])->assertCreated();

        $baseUrl = 'http://'.$tenantResponse->json('tenant.domain');

        $create = $this->postJson("{$baseUrl}/api/v1/suppliers", [
            'name' => 'Test Supplier',
            'email' => 'supplier@example.com',
            'rating' => 4.7,
        ])->assertCreated();

        $supplierId = (int) $create->json('supplier.id');

        $this->getJson("{$baseUrl}/api/v1/suppliers?search=Test")
            ->assertOk()
            ->assertJsonPath('data.0.id', $supplierId);

        $this->patchJson("{$baseUrl}/api/v1/suppliers/{$supplierId}", [
            'phone' => '+970-59-123-4567',
        ])->assertOk()
            ->assertJsonPath('supplier.phone', '+970-59-123-4567');

        $product = $this->postJson("{$baseUrl}/api/v1/products", [
            'sku' => 'KB-001',
            'name' => 'Mechanical Keyboard',
            'brand' => 'Keychron',
            'price' => 99.99,
            'cost_price' => 75,
            'stock_quantity' => 20,
            'category_id' => 1,
            'supplier_id' => $supplierId,
            'status' => 'active',
        ])->assertCreated();

        $productId = (int) $product->json('product.id');

        $this->deleteJson("{$baseUrl}/api/v1/suppliers/{$supplierId}")
            ->assertStatus(422)
            ->assertJsonPath('message', 'Supplier cannot be deleted while products are linked to it.');

        $this->deleteJson("{$baseUrl}/api/v1/products/{$productId}")->assertOk();

        $this->deleteJson("{$baseUrl}/api/v1/suppliers/{$supplierId}")
            ->assertOk()
            ->assertJsonPath('message', 'Supplier deleted successfully.');
    }
}
