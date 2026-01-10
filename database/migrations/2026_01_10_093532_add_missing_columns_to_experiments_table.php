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
        Schema::table('experiments', function (Blueprint $table) {
            $table->text('hypothesis')->nullable()->after('description');
            $table->text('procedure')->nullable()->after('hypothesis');
            $table->text('results')->nullable()->after('procedure');
            $table->text('conclusions')->nullable()->after('results');
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned')->after('conclusions');
            $table->decimal('duration', 8, 2)->nullable()->after('status')->comment('Duration in hours');

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['hypothesis', 'procedure', 'results', 'conclusions', 'status', 'duration']);
        });
    }
};
