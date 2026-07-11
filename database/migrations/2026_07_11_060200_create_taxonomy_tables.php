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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('skills_master', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert initial categories
        $categories = [
            'Software Development',
            'Design',
            'Marketing',
            'Operations',
            'Customer Support',
        ];
        foreach ($categories as $cat) {
            DB::table('job_categories')->insert([
                'name' => $cat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert initial skills
        $skills = [
            'Laravel',
            'PHP',
            'MySQL',
            'React',
            'Figma',
            'SEO',
            'Git',
            'Python',
            'Docker',
            'AWS',
        ];
        foreach ($skills as $skill) {
            DB::table('skills_master')->insert([
                'name' => $skill,
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
        Schema::dropIfExists('skills_master');
        Schema::dropIfExists('job_categories');
    }
};
