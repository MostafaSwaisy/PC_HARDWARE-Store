<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_category_crud_and_delete_guard_work_on_tenant_domain(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tenantResponse = $this->postJson('/api/v1/tenants', [
            'name' => 'Category Store',
            'subdomain' => 'category-store',
        ])->assertCreated();

        $baseUrl = 'http://'.$tenantResponse->json('tenant.domain');

        $create = $this->postJson("{$baseUrl}/api/v1/categories", [
            'name' => 'Monitors',
        ])->assertCreated();

        $categoryId = (int) $create->json('category.id');

        $this->getJson("{$baseUrl}/api/v1/categories?search=Monitor")
            ->assertOk()
            ->assertJsonPath('data.0.id', $categoryId);

        $this->putJson("{$baseUrl}/api/v1/categories/{$categoryId}", [
            'name' => 'Displays',
        ])->assertOk()
            ->assertJsonPath('category.name', 'Displays');

        $product = $this->postJson("{$baseUrl}/api/v1/products", [
            'sku' => 'MON-001',
            'name' => '27 inch Monitor',
            'brand' => 'LG',
            'price' => 199.99,
            'cost_price' => 170,
            'stock_quantity' => 12,
            'category_id' => $categoryId,
            'supplier_id' => 1,
            'status' => 'active',
        ])->assertCreated();

        $productId = (int) $product->json('product.id');

        $this->deleteJson("{$baseUrl}/api/v1/categories/{$categoryId}")
            ->assertStatus(422)
            ->assertJsonPath('message', 'Category cannot be deleted while products are linked to it.');

        $this->deleteJson("{$baseUrl}/api/v1/products/{$productId}")->assertOk();

        $this->deleteJson("{$baseUrl}/api/v1/categories/{$categoryId}")
            ->assertOk()
            ->assertJsonPath('message', 'Category deleted successfully.');
    }
}
