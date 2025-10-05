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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 200);
            $table->string('name_fr', 200);
            $table->string('name_en', 200);
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('serial_number', 100)->nullable()->unique();
            $table->string('category', 100);
            $table->string('location', 200)->nullable();
            $table->enum('status', ['available', 'reserved', 'maintenance', 'out_of_order'])->default('available');
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->string('maintenance_schedule', 200)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('category');
            $table->fullText(['name_ar', 'name_fr', 'name_en']);
            $table->fullText(['description_ar', 'description_fr', 'description_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};