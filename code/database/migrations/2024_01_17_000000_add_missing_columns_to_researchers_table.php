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
        Schema::table('researchers', function (Blueprint $table) {
            $table->string('department', 200)->nullable()->after('research_domain');
            $table->string('position', 200)->nullable()->after('department');
            $table->string('specialization', 200)->nullable()->after('position');
            $table->string('orcid_id', 19)->nullable()->unique()->after('specialization');
            $table->text('education')->nullable()->after('orcid_id');
            $table->integer('experience_years')->default(0)->after('education');
            $table->integer('current_projects_count')->default(0)->after('experience_years');
            $table->integer('publications_count')->default(0)->after('current_projects_count');
            $table->text('bio')->nullable()->after('bio_en');
            $table->string('website', 500)->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('website');
            $table->date('hire_date')->nullable()->after('is_active');
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'visiting'])->default('full_time')->after('hire_date');
            $table->json('skills')->nullable()->after('employment_type');
            $table->json('certifications')->nullable()->after('skills');
            $table->softDeletes();

            // Add indexes
            $table->index('department');
            $table->index('position');
            $table->index('specialization');
            $table->index('is_active');
            $table->index('hire_date');
            $table->index('employment_type');
            $table->index('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researchers', function (Blueprint $table) {
            $table->dropIndex(['department']);
            $table->dropIndex(['position']);
            $table->dropIndex(['specialization']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['hire_date']);
            $table->dropIndex(['employment_type']);
            $table->dropIndex(['experience_years']);

            $table->dropSoftDeletes();
            $table->dropColumn([
                'department',
                'position',
                'specialization',
                'orcid_id',
                'education',
                'experience_years',
                'current_projects_count',
                'publications_count',
                'bio',
                'website',
                'is_active',
                'hire_date',
                'employment_type',
                'skills',
                'certifications'
            ]);
        });
    }
};