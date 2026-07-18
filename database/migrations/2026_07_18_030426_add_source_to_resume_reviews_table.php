<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resume_reviews', function (Blueprint $table) {
            $table->string('source')->default('manual')->after('reviewed_by'); // 'manual' or 'ai'
        });
    }

    public function down(): void
    {
        Schema::table('resume_reviews', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};