<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('max_salary');
            $table->text('skills')->nullable()->after('deadline');
            $table->text('requirements')->nullable()->after('skills');
            $table->text('benefits')->nullable()->after('requirements');
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'skills', 'requirements', 'benefits']);
        });
    }
};
