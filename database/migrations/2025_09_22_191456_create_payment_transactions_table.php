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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->uuid();
            $table->foreignId('user_id')->constrained();
            $table->string('provider');
            $table->unsignedBigInteger('amount')->default(0);
            $table->enum('status', ['pending', 'paid', 'verified', 'cancelled', 'failed'])->default('pending');
            $table->json('token_response')->nullable();
            $table->json('callback_response')->nullable();
            $table->json('verified_response')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
