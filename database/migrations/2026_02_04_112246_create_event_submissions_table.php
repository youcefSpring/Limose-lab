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
        Schema::create('event_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Submission details
            $table->string('title');
            $table->text('abstract');
            $table->text('authors')->nullable(); // JSON or comma-separated
            $table->string('submission_type')->default('paper'); // paper, poster, abstract
            $table->string('category')->nullable();
            $table->text('keywords')->nullable();

            // File uploads
            $table->string('paper_file')->nullable();
            $table->string('presentation_file')->nullable();
            $table->string('supplementary_files')->nullable(); // JSON array

            // Review and status
            $table->enum('status', ['pending', 'under_review', 'accepted', 'rejected', 'revision_requested'])->default('pending');
            $table->text('reviewer_notes')->nullable();
            $table->text('author_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();

            // Metadata
            $table->integer('review_score')->nullable();
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('submission_type');
            $table->index(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_submissions');
    }
};
