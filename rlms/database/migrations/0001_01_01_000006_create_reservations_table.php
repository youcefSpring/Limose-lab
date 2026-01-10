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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedInteger('quantity')->default(1);
            $table->string('purpose', 1000);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled', 'completed'])->default('pending');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('material_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
            $table->index(['material_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
