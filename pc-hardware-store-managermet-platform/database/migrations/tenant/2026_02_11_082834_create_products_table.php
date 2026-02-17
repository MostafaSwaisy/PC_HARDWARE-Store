<?php

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('brand');
            $table->decimal('price',10,2);
            $table->decimal('cost_price' , 10 , 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->json('specifications')->nullable();
            $table->json('images')->nullable();
            $table->json('compatibility_data')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->enum('status' , ProductStatus::values())->default(ProductStatus::Active->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
