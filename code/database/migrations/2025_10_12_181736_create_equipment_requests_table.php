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
        Schema::create('equipment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->nullable()->constrained()->onDelete('set null');
            $table->string('equipment_name');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_progress', 'completed'])->default('pending');
            $table->date('requested_date');
            $table->time('requested_start_time');
            $table->time('requested_end_time');
            $table->text('purpose');
            $table->integer('estimated_users')->default(1);
            $table->text('special_requirements')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('assigned_desk_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_requests');
    }
};
