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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('type', 50)->default('string'); // string, integer, boolean, json, etc.
            $table->string('group', 50)->default('general'); // general, email, notifications, etc.
            $table->string('label', 200);
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false); // Can be accessed without authentication
            $table->boolean('is_editable')->default(true);
            $table->json('validation_rules')->nullable(); // Laravel validation rules
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('key');
            $table->index('group');
            $table->index('is_public');
            $table->index('is_editable');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};