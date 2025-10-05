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
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('model', 200)->nullable()->after('name_en');
            $table->string('manufacturer', 200)->nullable()->after('model');
            $table->decimal('purchase_price', 12, 2)->nullable()->after('warranty_expiry');
            $table->decimal('current_value', 12, 2)->nullable()->after('purchase_price');
            $table->string('supplier', 200)->nullable()->after('current_value');
            $table->text('specifications')->nullable()->after('description_en');
            $table->text('operating_instructions')->nullable()->after('specifications');
            $table->text('safety_instructions')->nullable()->after('operating_instructions');
            $table->integer('max_users_per_session')->default(1)->after('safety_instructions');
            $table->integer('booking_duration_hours')->default(2)->after('max_users_per_session');
            $table->boolean('requires_training')->default(false)->after('booking_duration_hours');
            $table->boolean('is_calibrated')->default(true)->after('requires_training');
            $table->date('last_calibration_date')->nullable()->after('is_calibrated');
            $table->date('next_calibration_date')->nullable()->after('last_calibration_date');
            $table->date('next_maintenance_date')->nullable()->after('maintenance_schedule');
            $table->text('maintenance_notes')->nullable()->after('next_maintenance_date');
            $table->integer('usage_hours')->default(0)->after('maintenance_notes');
            $table->boolean('is_active')->default(true)->after('usage_hours');
            $table->json('attachments')->nullable()->after('is_active');
            $table->softDeletes();

            // Add indexes
            $table->index('model');
            $table->index('manufacturer');
            $table->index('supplier');
            $table->index('requires_training');
            $table->index('is_calibrated');
            $table->index('next_calibration_date');
            $table->index('next_maintenance_date');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropIndex(['model']);
            $table->dropIndex(['manufacturer']);
            $table->dropIndex(['supplier']);
            $table->dropIndex(['requires_training']);
            $table->dropIndex(['is_calibrated']);
            $table->dropIndex(['next_calibration_date']);
            $table->dropIndex(['next_maintenance_date']);
            $table->dropIndex(['is_active']);

            $table->dropSoftDeletes();
            $table->dropColumn([
                'model',
                'manufacturer',
                'purchase_price',
                'current_value',
                'supplier',
                'specifications',
                'operating_instructions',
                'safety_instructions',
                'max_users_per_session',
                'booking_duration_hours',
                'requires_training',
                'is_calibrated',
                'last_calibration_date',
                'next_calibration_date',
                'next_maintenance_date',
                'maintenance_notes',
                'usage_hours',
                'is_active',
                'attachments'
            ]);
        });
    }
};