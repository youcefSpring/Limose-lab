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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('options')->nullable()->after('type');
            $table->boolean('is_multilingual')->default(false)->after('options');
            $table->integer('order')->default(0)->after('is_multilingual');
            $table->string('category')->nullable()->after('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['options', 'is_multilingual', 'order', 'category']);
        });
    }
};
