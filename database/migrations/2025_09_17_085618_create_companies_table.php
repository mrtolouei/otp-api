<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('national_id');
            $table->string('sender_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('client_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
