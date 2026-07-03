<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
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

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('university')->nullable();
            $table->string('department')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('company_logo')->nullable();
        });
    }
};
