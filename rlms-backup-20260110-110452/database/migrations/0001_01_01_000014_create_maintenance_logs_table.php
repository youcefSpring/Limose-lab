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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade');
            $table->enum('maintenance_type', ['preventive', 'corrective', 'inspection']);
            $table->text('description');
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed'])->default('scheduled');
            $table->timestamps();

            // Indexes
            $table->index('material_id');
            $table->index('technician_id');
            $table->index('status');
            $table->index(['scheduled_date', 'completed_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
