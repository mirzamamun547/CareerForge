<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\JobApplication;
use App\Notifications\InterviewScheduled;
use App\Notifications\InterviewCancelled;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class InterviewController extends Controller
{
    public function employerIndex(): View
    {
        $interviews = auth()->user()->interviewsAsEmployer()
            ->with(['student.studentProfile', 'jobApplication.jobListing'])
            ->latest('scheduled_at')
            ->get();

        $upcoming = $interviews->filter(fn($i) => $i->status === 'scheduled' && $i->scheduled_at->isAfter(now()));
        $past = $interviews->filter(fn($i) => $i->status !== 'scheduled' || $i->scheduled_at->isBefore(now()));

        return view('employer.interview-schedule', compact('upcoming', 'past'));
    }

    public function create(Request $request): View
    {
        // Get applications for jobs owned by this employer that are not rejected/withdrawn/hired
        $applications = JobApplication::with(['student', 'jobListing'])
            ->whereHas('jobListing', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereNotIn('status', ['Rejected', 'Withdrawn', 'Hired'])
            ->get();

        $preselectedApplicationId = $request->input('application_id');
        $preselectedApplication = null;
        if ($preselectedApplicationId) {
            $preselectedApplication = $applications->firstWhere('id', $preselectedApplicationId);
        }

        return view('employer.schedule-interview', compact('applications', 'preselectedApplication', 'preselectedApplicationId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'job_application_id' => ['required', 'exists:job_applications,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'string'],
            'type' => ['required', 'in:online,onsite'],
            'location' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $application = JobApplication::findOrFail($validated['job_application_id']);
        
        // Ensure this application belongs to a job listing of this employer
        abort_unless($application->jobListing->user_id === auth()->id(), 403);

        // Combine date and time
        try {
            $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', $validated['date'] . ' ' . $validated['time']);
        } catch (\Exception $e) {
            return back()->withErrors(['time' => 'The scheduled time format is invalid.'])->withInput();
        }

        // Check if there is an existing scheduled interview for this application
        $existing = Interview::where('job_application_id', $application->id)
            ->where('status', 'scheduled')
            ->first();

        if ($existing) {
            return back()->withErrors(['job_application_id' => 'An active interview is already scheduled for this candidate application.'])->withInput();
        }

        // Create the interview
        $interview = Interview::create([
            'job_application_id' => $application->id,
            'employer_id' => auth()->id(),
            'student_id' => $application->student_id,
            'scheduled_at' => $scheduledAt,
            'type' => $validated['type'],
            'location' => $validated['location'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'scheduled',
        ]);

        // Automatically change the application status to 'Interview' if it wasn't already
        if ($application->status !== 'Interview') {
            $oldStatus = $application->status;
            $application->update(['status' => 'Interview']);
            // Notify student of status change
            $application->student->notify(new \App\Notifications\ApplicationStatusChanged($application, $oldStatus, 'Interview'));
        }

        // Notify student of interview scheduled
        $application->student->notify(new InterviewScheduled($interview));

        return redirect()->route('employer.interview-schedule')->with('success', 'Interview scheduled successfully and student notified.');
    }

    public function cancel(Request $request, Interview $interview): RedirectResponse
    {
        // Authorize employer
        abort_unless($interview->employer_id === auth()->id(), 403);

        if ($interview->status === 'scheduled') {
            $interview->update(['status' => 'cancelled']);

            // Notify student of cancellation
            $interview->student->notify(new InterviewCancelled($interview));

            return back()->with('success', 'Interview cancelled successfully.');
        }

        return back()->with('error', 'Only active scheduled interviews can be cancelled.');
    }

    public function studentIndex(): View
    {
        $interviews = auth()->user()->interviewsAsStudent()
            ->with(['employer.employerProfile', 'jobApplication.jobListing'])
            ->latest('scheduled_at')
            ->get();

        $upcoming = $interviews->filter(fn($i) => $i->status === 'scheduled' && $i->scheduled_at->isAfter(now()));
        $past = $interviews->filter(fn($i) => $i->status !== 'scheduled' || $i->scheduled_at->isBefore(now()));

        return view('student.interviews', compact('upcoming', 'past'));
    }
}
