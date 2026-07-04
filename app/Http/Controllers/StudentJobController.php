<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobBookmark;
use App\Models\JobListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentJobController extends Controller
{
    public function index(): View
    {
        $jobs = JobListing::where('status', 'Active')->with('user')->latest()->get();
        $bookmarkedIds = auth()->user()->jobBookmarks()->pluck('job_listing_id');

        return view('student.jobs', compact('jobs', 'bookmarkedIds'));
    }

    public function show(JobListing $job): View
    {
        $job->load('user');
        $bookmarked = auth()->user()->jobBookmarks()->where('job_listing_id', $job->id)->exists();

        return view('student.job-details', compact('job', 'bookmarked'));
    }

    public function showApplyForm(JobListing $job): View
    {
        $job->load('user');

        return view('student.apply-job', compact('job'));
    }

    public function apply(Request $request, JobListing $job): RedirectResponse
    {
        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ]);

        $existing = $job->applications()->where('student_id', $request->user()->id)->exists();

        if (! $existing) {
            $job->applications()->create([
                'student_id' => $request->user()->id,
                'status' => 'Applied',
                'cover_letter' => $validated['cover_letter'] ?? null,
            ]);
        }

        return redirect()->route('student.jobs.apply.success', $job);
    }

    public function applySuccess(JobListing $job): View
    {
        $job->load('user');

        return view('student.apply-success', compact('job'));
    }

    public function bookmark(Request $request, JobListing $job): RedirectResponse
    {
        $existing = $request->user()->jobBookmarks()->where('job_listing_id', $job->id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            JobBookmark::create([
                'student_id' => $request->user()->id,
                'job_listing_id' => $job->id,
            ]);
        }

        return redirect()->route('student.jobs');
    }

    public function applications(): View
    {
        $applications = auth()->user()->jobApplications()->with('jobListing.user')->latest()->get();

        return view('student.applications', compact('applications'));
    }

    public function employerApplicants(): View
    {
        $applications = JobApplication::with(['student', 'jobListing'])
            ->whereHas('jobListing', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('employer.applicants', compact('applications'));
    }

    public function employerApplicantDetails(JobApplication $application): View
    {
        abort_unless($application->jobListing->user_id === auth()->id(), 403);

        return view('employer.applicant-details', compact('application'));
    }
}
