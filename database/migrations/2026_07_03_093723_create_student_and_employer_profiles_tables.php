<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('university')->nullable();
            $table->string('department')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });

        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('company_logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_profiles');
        Schema::dropIfExists('student_profiles');
    }
};
