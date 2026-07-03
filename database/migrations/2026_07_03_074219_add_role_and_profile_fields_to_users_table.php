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
            // Core role field
            $table->enum('role', ['student', 'employer', 'admin'])
                ->default('student')
                ->after('email');

            // Shared fields
            $table->string('phone')->nullable()->after('role');
            $table->string('profile_picture')->nullable()->after('phone');

            // Student-specific fields
            $table->string('university')->nullable()->after('profile_picture');
            $table->string('department')->nullable()->after('university');
            $table->unsignedSmallInteger('graduation_year')->nullable()->after('department');

            // Employer-specific fields
            $table->string('company_name')->nullable()->after('graduation_year');
            $table->string('company_email')->nullable()->after('company_name');
            $table->string('website')->nullable()->after('company_email');
            $table->string('industry')->nullable()->after('website');
            $table->text('company_address')->nullable()->after('industry');
            $table->string('contact_person')->nullable()->after('company_address');
            $table->string('company_logo')->nullable()->after('contact_person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'profile_picture',
                'university',
                'department',
                'graduation_year',
                'company_name',
                'company_email',
                'website',
                'industry',
                'company_address',
                'contact_person',
                'company_logo',
            ]);
        });
    }
};
