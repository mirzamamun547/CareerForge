<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Link each existing per-student skill row to the master list.
        Schema::table('skills', function (Blueprint $table) {
            $table->foreignId('skill_master_id')->nullable()->after('student_profile_id')
                ->constrained('skills_master')->nullOnDelete();
        });

        // 2. Job listing <-> required skill (many-to-many, structured).
        Schema::create('job_listing_skill_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_master_id')->constrained('skills_master')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['job_listing_id', 'skill_master_id']);
        });

        // 3. Backfill: resolve every existing free-text student skill name
        //    into skills_master, and link the row back.
        $existingNames = DB::table('skills')->whereNull('skill_master_id')->pluck('name')->unique();

        foreach ($existingNames as $name) {
            $trimmed = trim($name);
            if ($trimmed === '') {
                continue;
            }

            $masterId = DB::table('skills_master')->whereRaw('LOWER(name) = ?', [strtolower($trimmed)])->value('id');
            if (!$masterId) {
                $masterId = DB::table('skills_master')->insertGetId([
                    'name' => $trimmed,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('skills')->where('name', $name)->update(['skill_master_id' => $masterId]);
        }

        // 4. Backfill: parse job_listings.skills (comma-separated text)
        //    into the pivot table.
        $jobs = DB::table('job_listings')->select('id', 'skills')->whereNotNull('skills')->get();

        foreach ($jobs as $job) {
            $names = array_filter(array_map('trim', explode(',', $job->skills)));

            foreach ($names as $name) {
                $masterId = DB::table('skills_master')->whereRaw('LOWER(name) = ?', [strtolower($name)])->value('id');
                if (!$masterId) {
                    $masterId = DB::table('skills_master')->insertGetId([
                        'name' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('job_listing_skill_master')->insertOrIgnore([
                    'job_listing_id' => $job->id,
                    'skill_master_id' => $masterId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listing_skill_master');

        Schema::table('skills', function (Blueprint $table) {
            $table->dropConstrainedForeignId('skill_master_id');
        });
    }
};