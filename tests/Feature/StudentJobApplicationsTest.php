<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Resume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentJobApplicationsTest extends TestCase
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

    public function test_student_can_apply_to_a_job_and_view_applications(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
        
        $profile = StudentProfile::create([
            'user_id' => $student->id,
            'phone' => '+8801711223344',
            'university' => 'DU',
            'department' => 'CSE',
            'graduation_year' => 2026,
        ]);
        
        $profile->resumes()->create([
            'file_path' => 'resumes/dummy.pdf',
            'status' => 'pending',
        ]);

        $job = JobListing::create([
            'user_id' => $employer->id,
            'title' => 'Laravel Developer',
            'category' => 'Development',
            'job_type' => 'Full Time',
            'location' => 'Dhaka',
            'min_salary' => 40000,
            'max_salary' => 70000,
            'description' => 'Build apps.',
            'status' => 'Active',
        ]);

        $this->actingAs($student);

        $browseResponse = $this->get(route('student.jobs'));
        $browseResponse->assertSee('Laravel Developer');

        $applyFormResponse = $this->get(route('student.jobs.apply.form', $job));
        $applyFormResponse->assertStatus(200)->assertSee('Complete your application');

        $applyResponse = $this->post(route('student.jobs.apply', $job), [
            'cover_letter' => 'I am very excited to contribute to your team and work with you.',
        ]);
        $applyResponse->assertRedirect(route('student.jobs.apply.success', $job));

        $this->assertDatabaseHas('job_applications', [
            'student_id' => $student->id,
            'job_listing_id' => $job->id,
            'status' => 'Applied',
        ]);

        $applicationsResponse = $this->get(route('student.applications'));
        $applicationsResponse->assertSee('Laravel Developer');
    }

    public function test_employer_can_view_applicants_for_their_jobs(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
        $job = JobListing::create([
            'user_id' => $employer->id,
            'title' => 'Backend Developer',
            'category' => 'Development',
            'job_type' => 'Full Time',
            'location' => 'Remote',
            'min_salary' => 50000,
            'max_salary' => 80000,
            'description' => 'API work.',
            'status' => 'Active',
        ]);

        $application = $job->applications()->create([
            'student_id' => $student->id,
            'status' => 'Applied',
        ]);

        $this->actingAs($employer);

        $applicantsResponse = $this->get(route('employer.applicants'));
        $applicantsResponse->assertSee($student->name);
        $applicantsResponse->assertSee('Backend Developer');

        $detailsResponse = $this->get(route('employer.applicant-details', $application));
        $detailsResponse->assertSee($student->name);
    }

    public function test_student_can_bookmark_and_view_job_details(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
        $job = JobListing::create([
            'user_id' => $employer->id,
            'title' => 'React Developer',
            'category' => 'Development',
            'job_type' => 'Remote',
            'location' => 'Sylhet',
            'level' => 'Mid Level',
            'min_salary' => 35000,
            'max_salary' => 55000,
            'description' => 'Build UI.',
            'status' => 'Active',
        ]);

        $this->actingAs($student);

        $response = $this->post(route('student.jobs.bookmark', $job));
        $response->assertRedirect(route('student.jobs'));

        $this->assertDatabaseHas('job_bookmarks', [
            'student_id' => $student->id,
            'job_listing_id' => $job->id,
        ]);

        $detailsResponse = $this->get(route('student.jobs.show', $job));
        $detailsResponse->assertSee('React Developer');
        $detailsResponse->assertSee('Apply Now');
    }
}
