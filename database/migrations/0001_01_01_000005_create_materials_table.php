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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('category_id')->constrained('material_categories')->onDelete('restrict');
            $table->unsignedInteger('quantity')->default(1);
            $table->enum('status', ['available', 'maintenance', 'retired'])->default('available');
            $table->string('location');
            $table->string('serial_number', 100)->nullable()->unique();
            $table->date('purchase_date')->nullable();
            $table->string('image')->nullable();
            $table->enum('maintenance_schedule', ['weekly', 'monthly', 'quarterly', 'yearly'])->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('category_id');
            $table->index('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
