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
        Schema::create('experiment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained('experiments')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path', 500);
            $table->unsignedInteger('file_size');
            $table->string('mime_type', 100);
            $table->timestamp('uploaded_at')->useCurrent();

            // Index
            $table->index('experiment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_files');
    }
};
