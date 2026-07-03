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
        // 1. Update student_profiles table
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('user_id');
            $table->string('profile_picture')->nullable()->after('phone');
            $table->dropColumn('resume');
        });

        // 2. Create resumes table
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->string('resume')->nullable()->after('graduation_year');
            $table->dropColumn(['phone', 'profile_picture']);
        });
    }
};
