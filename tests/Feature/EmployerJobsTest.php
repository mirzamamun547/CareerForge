<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployerJobsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function test_employer_can_post_and_manage_jobs(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->actingAs($employer);

        $response = $this->post(route('employer.jobs.store'), [
            'title' => 'Senior Laravel Developer',
            'category' => 'Development',
            'job_type' => 'Full Time',
            'location' => 'Dhaka, Bangladesh',
            'min_salary' => 80000,
            'max_salary' => 120000,
            'description' => 'Build modern Laravel applications.',
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('employer.manage-jobs'));
        $this->assertDatabaseHas('job_listings', [
            'title' => 'Senior Laravel Developer',
            'user_id' => $employer->id,
        ]);

        $manageResponse = $this->get(route('employer.manage-jobs'));
        $manageResponse->assertSee('Senior Laravel Developer');
    }

    public function test_employer_can_update_a_job_listing(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = JobListing::create([
            'user_id' => $employer->id,
            'title' => 'Junior PHP Developer',
            'category' => 'Development',
            'job_type' => 'Full Time',
            'location' => 'Remote',
            'min_salary' => 40000,
            'max_salary' => 70000,
            'description' => 'Initial role.',
            'status' => 'Active',
        ]);

        $this->actingAs($employer);

        $response = $this->put(route('employer.jobs.update', $job), [
            'title' => 'Mid PHP Developer',
            'category' => 'Development',
            'job_type' => 'Part Time',
            'location' => 'Remote',
            'min_salary' => 50000,
            'max_salary' => 90000,
            'description' => 'Updated role.',
            'status' => 'Inactive',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('job_listings', [
            'id' => $job->id,
            'title' => 'Mid PHP Developer',
            'job_type' => 'Part Time',
            'status' => 'Inactive',
        ]);
    }

    public function test_manage_jobs_page_shows_extended_edit_fields_and_preview(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        JobListing::create([
            'user_id' => $employer->id,
            'title' => 'Junior PHP Developer',
            'category' => 'Development',
            'job_type' => 'Full Time',
            'location' => 'Remote',
            'min_salary' => 40000,
            'max_salary' => 70000,
            'description' => 'Initial role.',
            'status' => 'Active',
        ]);

        $this->actingAs($employer);

        $response = $this->get(route('employer.manage-jobs'));

        $response->assertOk();
        $response->assertSee('Skills');
        $response->assertSee('Benefits');
        $response->assertSee('Preview Job');
    }
}
