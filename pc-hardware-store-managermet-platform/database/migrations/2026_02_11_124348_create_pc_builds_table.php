<?php

use App\Enums\PcBuildStatus;
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
        Schema::create('pc_builds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('build_name');
            $table->string('purpose');
            $table->string('status',PcBuildStatus::values())->default(PcBuildStatus::Draft->value);
            $table->decimal('budget_max', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->json('compatibility_issues')->nullable();
            $table->json('ai_recommendations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_builds');
    }
};
