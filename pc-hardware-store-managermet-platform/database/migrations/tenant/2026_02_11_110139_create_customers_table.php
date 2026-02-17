<?php

use App\Enums\CustomerTypes;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('address')->nullable();
            $table->decimal('total_purchases', 10, 2)->default(0);
            $table->integer('loyalty_points')->default(0);
            $table->enum('customer_type', CustomerTypes::values())->default(CustomerTypes::WalkIn->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
