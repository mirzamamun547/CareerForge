<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use App\Models\Interview;
use App\Models\JobApplication;
use App\Notifications\InterviewScheduled;
use App\Notifications\InterviewCancelled;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InterviewSchedulingTest extends TestCase
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

    public function test_employer_can_schedule_interview_and_student_is_notified(): void
    {
        Notification::fake();

        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
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

        $application = $job->applications()->create([
            'student_id' => $student->id,
            'status' => 'Shortlisted',
        ]);

        $this->actingAs($employer);

        $response = $this->post(route('employer.schedule-interview.store'), [
            'job_application_id' => $application->id,
            'date' => date('Y-m-d', strtotime('+2 days')),
            'time' => '10:00',
            'type' => 'online',
            'location' => 'https://zoom.us/j/123456',
            'notes' => 'Be prepared with Laravel questions.',
        ]);

        $response->assertRedirect(route('employer.interview-schedule'));

        // Assert interview is in the database
        $this->assertDatabaseHas('interviews', [
            'job_application_id' => $application->id,
            'employer_id' => $employer->id,
            'student_id' => $student->id,
            'type' => 'online',
            'location' => 'https://zoom.us/j/123456',
            'status' => 'scheduled',
        ]);

        // Assert job application status was updated to Interview
        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'Interview',
        ]);

        // Assert notification was sent to student
        Notification::assertSentTo($student, InterviewScheduled::class);
    }

    public function test_employer_cannot_schedule_duplicate_interview(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
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

        $application = $job->applications()->create([
            'student_id' => $student->id,
            'status' => 'Shortlisted',
        ]);

        $this->actingAs($employer);

        // Schedule first interview
        $this->post(route('employer.schedule-interview.store'), [
            'job_application_id' => $application->id,
            'date' => date('Y-m-d', strtotime('+2 days')),
            'time' => '10:00',
            'type' => 'online',
            'location' => 'https://zoom.us/j/123456',
        ]);

        // Attempt scheduling second interview for the same application
        $response = $this->post(route('employer.schedule-interview.store'), [
            'job_application_id' => $application->id,
            'date' => date('Y-m-d', strtotime('+3 days')),
            'time' => '11:00',
            'type' => 'onsite',
            'location' => 'Office',
        ]);

        $response->assertSessionHasErrors('job_application_id');
        $this->assertEquals(1, Interview::count());
    }

    public function test_employer_can_cancel_scheduled_interview_and_student_is_notified(): void
    {
        Notification::fake();

        $employer = User::factory()->create(['role' => 'employer']);
        $student = User::factory()->create(['role' => 'student']);
        $job = JobListing::create([
            'user_id' => $employer->id,
            'title' => 'Laravel Developer',
            'status' => 'Active',
            'category' => 'Dev',
            'job_type' => 'FT',
            'location' => 'Dhaka',
            'min_salary' => 10,
            'max_salary' => 20,
            'description' => 'Test',
        ]);

        $application = $job->applications()->create([
            'student_id' => $student->id,
            'status' => 'Interview',
        ]);

        $interview = Interview::create([
            'job_application_id' => $application->id,
            'employer_id' => $employer->id,
            'student_id' => $student->id,
            'scheduled_at' => now()->addDays(2),
            'type' => 'online',
            'location' => 'zoom',
            'status' => 'scheduled',
        ]);

        $this->actingAs($employer);

        $response = $this->post(route('employer.interviews.cancel', $interview));
        $response->assertRedirect();

        $this->assertDatabaseHas('interviews', [
            'id' => $interview->id,
            'status' => 'cancelled',
        ]);

        Notification::assertSentTo($student, InterviewCancelled::class);
    }
}
