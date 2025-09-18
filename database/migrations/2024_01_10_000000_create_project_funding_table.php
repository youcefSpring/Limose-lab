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
        Schema::create('project_funding', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('funding_source_id')->constrained('funding_sources')->onDelete('restrict');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('DZD');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'approved', 'active', 'completed', 'cancelled'])->default('pending');
            $table->string('grant_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('project_id');
            $table->index('funding_source_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_funding');
    }
};