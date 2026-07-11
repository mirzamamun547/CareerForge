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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('action');
            $table->string('details')->nullable();
            $table->timestamps();
        });

        // Insert initial mock activities
        $activities = [
            ['user_name' => 'Admin', 'action' => 'Approved employer', 'details' => 'NextGen Software', 'created_at' => now()->subMinutes(12)],
            ['user_name' => 'Admin', 'action' => 'Removed job listing', 'details' => '"Easy Money" Survey Job', 'created_at' => now()->subHours(2)],
            ['user_name' => 'TechSoft Ltd.', 'action' => 'Submitted resume review', 'details' => 'Tania Rahman — score 81/100', 'created_at' => now()->subHours(5)],
            ['user_name' => 'Admin', 'action' => 'Suspended account', 'details' => 'Sabbir Hossain', 'created_at' => now()->subDay()],
            ['user_name' => 'Admin', 'action' => 'Added skill', 'details' => 'Figma', 'created_at' => now()->subDays(2)],
        ];

        foreach ($activities as $act) {
            DB::table('activity_logs')->insert([
                'user_name' => $act['user_name'],
                'action' => $act['action'],
                'details' => $act['details'],
                'created_at' => $act['created_at'],
                'updated_at' => $act['created_at'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
