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
            $table->string('status')->default('active')->after('profile_picture');
            $table->boolean('verified')->default(true)->after('status');
        });

        // Set existing employers to verified as a starting state, or keep them unverified if desired
        // For simplicity, let's make all existing users verified
        DB::table('users')->update([
            'status' => 'active',
            'verified' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'verified']);
        });
    }
};
