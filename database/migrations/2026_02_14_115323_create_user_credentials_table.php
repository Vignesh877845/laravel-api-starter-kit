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
        Schema::create('user_credentials', function (Blueprint $table) {
            if (config('features.use_uuid')) {
                $table->uuid('id')->primary();
                $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            } else {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            $table->string('username')->unique()->nullable();
            $table->string('provider')->default('local');
            $table->string('provider_id')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_credentials');
    }
};
