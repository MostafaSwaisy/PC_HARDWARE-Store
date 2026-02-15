<?php

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
        Schema::create('supplier_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->date('expected_delivery')->nullable();
            $table->date('actual_delivery')->nullable();
            $table->string('status'); // pending, shipped, received, cancelled
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_orders');
    }
};
