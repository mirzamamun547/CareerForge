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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert initial settings
        $settings = [
            ['key' => 'require_employer_verification', 'value' => '1'],
            ['key' => 'auto_close_expired_jobs', 'value' => '1'],
            ['key' => 'maintenance_mode', 'value' => '0'],
        ];

        foreach ($settings as $set) {
            DB::table('settings')->insert([
                'key' => $set['key'],
                'value' => $set['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
