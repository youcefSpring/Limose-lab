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
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('progress_percentage', 5, 2)->default(0)->after('status');
            $table->string('project_code', 50)->unique()->nullable()->after('progress_percentage');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('project_code');
            $table->integer('duration_days')->nullable()->after('priority');
            $table->decimal('actual_budget', 15, 2)->nullable()->after('budget');
            $table->text('objectives')->nullable()->after('description_en');
            $table->text('methodology')->nullable()->after('objectives');
            $table->text('expected_outcomes')->nullable()->after('methodology');
            $table->json('keywords')->nullable()->after('expected_outcomes');
            $table->json('tags')->nullable()->after('keywords');
            $table->integer('members_count')->default(0)->after('tags');
            $table->integer('publications_count')->default(0)->after('members_count');
            $table->date('last_activity_date')->nullable()->after('publications_count');
            $table->boolean('is_public')->default(false)->after('last_activity_date');
            $table->string('external_funding_agency', 255)->nullable()->after('is_public');
            $table->string('grant_number', 100)->nullable()->after('external_funding_agency');
            $table->json('milestones')->nullable()->after('grant_number');
            $table->softDeletes();

            // Add indexes
            $table->index('progress_percentage');
            $table->index('priority');
            $table->index('duration_days');
            $table->index('members_count');
            $table->index('publications_count');
            $table->index('last_activity_date');
            $table->index('is_public');
            $table->index('external_funding_agency');
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