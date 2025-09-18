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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('status');
            $table->string('photo_url', 500)->nullable()->after('phone');
            $table->text('bio')->nullable()->after('photo_url');
            $table->string('department', 200)->nullable()->after('bio');
            $table->string('position', 200)->nullable()->after('department');
            $table->timestamp('last_login_at')->nullable()->after('position');
            $table->string('preferred_language', 2)->default('en')->after('last_login_at');
            $table->json('preferences')->nullable()->after('preferred_language');
            $table->softDeletes();

            // Add indexes
            $table->index('is_active');
            $table->index('last_login_at');
            $table->index('preferred_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['last_login_at']);
            $table->dropIndex(['preferred_language']);

            $table->dropSoftDeletes();
            $table->dropColumn([
                'is_active',
                'photo_url',
                'bio',
                'department',
                'position',
                'last_login_at',
                'preferred_language',
                'preferences'
            ]);
        });
    }
};