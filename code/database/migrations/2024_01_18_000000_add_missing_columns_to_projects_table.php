<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('projects', 'progress_percentage')) {
                $table->decimal('progress_percentage', 5, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('projects', 'project_code')) {
                $table->string('project_code', 50)->unique()->nullable()->after('progress_percentage');
            }
            if (!Schema::hasColumn('projects', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('project_code');
            }
            if (!Schema::hasColumn('projects', 'duration_days')) {
                $table->integer('duration_days')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('projects', 'actual_budget')) {
                $table->decimal('actual_budget', 15, 2)->nullable()->after('budget');
            }
            if (!Schema::hasColumn('projects', 'objectives')) {
                $table->text('objectives')->nullable()->after('description_en');
            }
            if (!Schema::hasColumn('projects', 'methodology')) {
                $table->text('methodology')->nullable()->after('objectives');
            }
            if (!Schema::hasColumn('projects', 'expected_outcomes')) {
                $table->text('expected_outcomes')->nullable()->after('methodology');
            }
            if (!Schema::hasColumn('projects', 'keywords')) {
                $table->json('keywords')->nullable()->after('expected_outcomes');
            }
            if (!Schema::hasColumn('projects', 'tags')) {
                $table->json('tags')->nullable()->after('keywords');
            }
            if (!Schema::hasColumn('projects', 'members_count')) {
                $table->integer('members_count')->default(0)->after('tags');
            }
            if (!Schema::hasColumn('projects', 'publications_count')) {
                $table->integer('publications_count')->default(0)->after('members_count');
            }
            if (!Schema::hasColumn('projects', 'last_activity_date')) {
                $table->date('last_activity_date')->nullable()->after('publications_count');
            }
            if (!Schema::hasColumn('projects', 'is_public')) {
                $table->boolean('is_public')->default(false)->after('last_activity_date');
            }
            if (!Schema::hasColumn('projects', 'external_funding_agency')) {
                $table->string('external_funding_agency', 255)->nullable()->after('is_public');
            }
            if (!Schema::hasColumn('projects', 'grant_number')) {
                $table->string('grant_number', 100)->nullable()->after('external_funding_agency');
            }
            if (!Schema::hasColumn('projects', 'milestones')) {
                $table->json('milestones')->nullable()->after('grant_number');
            }
            if (!Schema::hasColumn('projects', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add indexes (with error handling for existing indexes)
        Schema::table('projects', function (Blueprint $table) {
            try {
                $table->index('progress_percentage');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('priority');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('duration_days');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('members_count');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('publications_count');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('last_activity_date');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                $table->index('is_public');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
            try {
                DB::statement('ALTER TABLE projects ADD INDEX projects_external_funding_agency_index (external_funding_agency(100))');
            } catch (\Exception $e) {
                // Index already exists, skip
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['progress_percentage']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['duration_days']);
            $table->dropIndex(['members_count']);
            $table->dropIndex(['publications_count']);
            $table->dropIndex(['last_activity_date']);
            $table->dropIndex(['is_public']);
            $table->dropIndex(['external_funding_agency']);

            $table->dropSoftDeletes();
            $table->dropColumn([
                'progress_percentage',
                'project_code',
                'priority',
                'duration_days',
                'actual_budget',
                'objectives',
                'methodology',
                'expected_outcomes',
                'keywords',
                'tags',
                'members_count',
                'publications_count',
                'last_activity_date',
                'is_public',
                'external_funding_agency',
                'grant_number',
                'milestones'
            ]);
        });
    }
};