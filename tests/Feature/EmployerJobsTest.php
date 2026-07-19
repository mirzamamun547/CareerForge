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

    public function test_post_job_page_has_live_preview_targets(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $this->actingAs($employer);

        $response = $this->get(route('employer.jobs'));

        $response->assertOk();
        $response->assertSee('previewSidebarTitle', false);
        $response->assertSee('previewSidebarMeta', false);
    }

    public function test_employer_can_view_company_profile(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        \App\Models\EmployerProfile::create([
            'user_id' => $employer->id,
            'company_name' => 'Test Company',
            'company_email' => 'test@company.com',
            'website' => 'https://testcompany.com',
            'industry' => 'Tech',
            'company_address' => 'Test Location',
            'contact_person' => 'Test Contact',
        ]);

        $this->actingAs($employer);

        $response = $this->get(route('employer.company-profile'));

        $response->assertOk();
        $response->assertSee('Test Company');
        $response->assertSee('test@company.com');
        $response->assertSee('https://testcompany.com');
        $response->assertSee('Tech');
        $response->assertSee('Test Location');
        $response->assertSee('Test Contact');
    }

    public function test_employer_can_update_company_profile(): void
    {
        $employer = User::factory()->create(['role' => 'employer', 'phone' => '1234567890']);
        $profile = \App\Models\EmployerProfile::create([
            'user_id' => $employer->id,
            'company_name' => 'Old Company Name',
            'company_email' => 'old@company.com',
            'website' => 'https://oldcompany.com',
            'industry' => 'Old Tech',
            'company_address' => 'Old Location',
            'contact_person' => 'Old Contact',
        ]);

        $this->actingAs($employer);

        $response = $this->post(route('employer.company-profile.update'), [
            'company_name' => 'New Company Name',
            'company_email' => 'new@company.com',
            'phone' => '0987654321',
            'website' => 'https://newcompany.com',
            'company_address' => 'New Location',
            'industry' => 'New Tech',
            'contact_person' => 'New Contact',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('employer_profiles', [
            'id' => $profile->id,
            'company_name' => 'New Company Name',
            'company_email' => 'new@company.com',
            'website' => 'https://newcompany.com',
            'company_address' => 'New Location',
            'industry' => 'New Tech',
            'contact_person' => 'New Contact',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $employer->id,
            'phone' => '0987654321',
        ]);
    }
}
