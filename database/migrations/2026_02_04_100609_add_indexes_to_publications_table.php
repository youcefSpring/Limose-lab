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
        Schema::table('publications', function (Blueprint $table) {
            // Single column indexes for frequently filtered columns
            $table->index('year');
            $table->index('type');
            $table->index('status');
            $table->index('visibility');
            $table->index('is_featured');
            $table->index('publication_date');

            // Composite index for common query combination
            $table->index(['visibility', 'status'], 'idx_publications_visibility_status');

            // Index for user relationship (if not already indexed)
            if (!Schema::hasColumn('publications', 'user_id_index')) {
                $table->index('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Drop indexes in reverse order
            $table->dropIndex(['visibility', 'status']);
            $table->dropIndex(['publication_date']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['visibility']);
            $table->dropIndex(['status']);
            $table->dropIndex(['type']);
            $table->dropIndex(['year']);

            // Only drop user_id if we created it
            if (Schema::hasIndex('publications', 'publications_user_id_index')) {
                $table->dropIndex(['user_id']);
            }
        });
    }
};
