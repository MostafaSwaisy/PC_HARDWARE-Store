<?php

use App\Enums\ConversationStatus;
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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
             $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->uuid('session_id')->index();
            $table->string('conversation_type');
            $table->enum('status',ConversationStatus::values())->default(ConversationStatus::Active->value);
            $table->boolean('ai_handled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
