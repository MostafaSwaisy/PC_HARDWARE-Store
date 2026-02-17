<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_product_crud_works_on_tenant_domain(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tenantResponse = $this->postJson('/api/v1/tenants', [
            'name' => 'Hardware Hub',
            'subdomain' => 'hardware-hub',
        ])->assertCreated();

        $domain = $tenantResponse->json('tenant.domain');
        $this->assertNotEmpty($domain);
        $baseUrl = "http://{$domain}";

        $create = $this->postJson("{$baseUrl}/api/v1/products", [
            'sku' => 'CPU-7600-01',
            'name' => 'Ryzen 5 7600',
            'brand' => 'AMD',
            'price' => 249.99,
            'cost_price' => 220,
            'stock_quantity' => 25,
            'low_stock_threshold' => 5,
            'category_id' => 1,
            'supplier_id' => 1,
            'status' => 'active',
        ]);

        $create->assertCreated()
            ->assertJsonPath('product.sku', 'CPU-7600-01');

        $productId = (int) $create->json('product.id');

        $this->getJson("{$baseUrl}/api/v1/products")
            ->assertOk()
            ->assertJsonPath('data.0.id', $productId);

        $this->getJson("{$baseUrl}/api/v1/products?supplier_id=1&status=active")
            ->assertOk()
            ->assertJsonPath('data.0.id', $productId);

        $this->putJson("{$baseUrl}/api/v1/products/{$productId}", [
                'price' => 239.99,
                'stock_quantity' => 30,
            ])
            ->assertOk()
            ->assertJsonPath('product.price', '239.99')
            ->assertJsonPath('product.stock_quantity', 30);

        $this->deleteJson("{$baseUrl}/api/v1/products/{$productId}")
            ->assertOk()
            ->assertJsonPath('message', 'Product deleted successfully.');
    }
}
