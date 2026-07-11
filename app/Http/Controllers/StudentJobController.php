<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobBookmark;
use App\Models\JobListing;
use App\Models\ResumeReview;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\ApplicationStatusChanged;
use App\Notifications\NewApplicationReceived;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentJobController extends Controller
{
    public function index(Request $request): View
    {
        $query = JobListing::where('status', 'Active')->with('user');

        // Search text: Title, Company Name, Description, Skills
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Job Type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }

        // Level / Experience filter
        if ($request->filled('level')) {
            $query->where('level', $request->input('level'));
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        // Salary range (minimum threshold)
        if ($request->filled('salary')) {
            $query->where('min_salary', '>=', (int) $request->input('salary'));
        }

        // Remote only filter
        if ($request->boolean('remote')) {
            $query->where(function ($q) {
                $q->where('job_type', 'Remote')
                  ->orWhere('location', 'like', '%remote%');
            });
        }

        // Sorting / Order
        $sort = $request->input('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // --- Smart Job Matching (pure SQL, no AI) ---
        // For the logged-in student, count how many of the job's required
        // skills_master rows overlap with the student's own skills. Both
        // counts are computed as SQL subqueries (withCount), so no PHP-side
        // loop is needed to score every job.
        $studentProfile = auth()->user()->studentProfile;
        $studentSkillMasterIds = $studentProfile ? $studentProfile->skillMasterIds() : collect();

        $query->withCount('skillMasters as required_skills_count')
            ->withCount(['skillMasters as matched_skills_count' => function ($q) use ($studentSkillMasterIds) {
                $q->whereIn('skills_master.id', $studentSkillMasterIds);
            }]);

        if ($sort === 'match') {
            $query->orderByRaw('CASE WHEN required_skills_count > 0 THEN matched_skills_count / required_skills_count ELSE 0 END DESC');
        }

        $jobs = $query->paginate(10)->withQueryString();

        // Attach a 0-100 match_percentage to each job for display.
        $jobs->getCollection()->transform(function (JobListing $job) {
            $job->match_percentage = $job->required_skills_count > 0
                ? (int) round(($job->matched_skills_count / $job->required_skills_count) * 100)
                : null;

            return $job;
        });

        $bookmarkedIds = auth()->user()->jobBookmarks()->pluck('job_listing_id');
        
        // Dynamic options for filters
        $locations = JobListing::where('status', 'Active')->pluck('location')->unique()->filter()->values();
        $jobTypes = JobListing::where('status', 'Active')->pluck('job_type')->unique()->filter()->values();
        $levels = JobListing::where('status', 'Active')->pluck('level')->unique()->filter()->values();

        return view('student.jobs', compact('jobs', 'bookmarkedIds', 'locations', 'jobTypes', 'levels'));
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

        $existing = $job->applications()->where('student_id', $request->user()->id)->first();

        if (! $existing) {
            $application = $job->applications()->create([
                'student_id' => $request->user()->id,
                'status' => 'Applied',
                'cover_letter' => $validated['cover_letter'] ?? null,
            ]);

            // Dispatch Notifications
            // 1. Notify Student
            $request->user()->notify(new ApplicationSubmitted($application));

            // 2. Notify Employer
            $job->user->notify(new NewApplicationReceived($application));
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

    public function applications(Request $request): View
    {
        $query = auth()->user()->jobApplications()->with(['jobListing.user', 'jobListing.user.employerProfile']);
        
        // Filter by status if requested
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $applications = $query->latest()->paginate(10)->withQueryString();

        // Get status counts for stats & tabs
        $allApplications = auth()->user()->jobApplications;
        $counts = [
            'all' => $allApplications->count(),
            'Applied' => $allApplications->where('status', 'Applied')->count(),
            'Under Review' => $allApplications->where('status', 'Under Review')->count(),
            'Shortlisted' => $allApplications->where('status', 'Shortlisted')->count(),
            'Interview' => $allApplications->where('status', 'Interview')->count(),
            'Rejected' => $allApplications->where('status', 'Rejected')->count(),
            'Hired' => $allApplications->where('status', 'Hired')->count(),
            'Withdrawn' => $allApplications->where('status', 'Withdrawn')->count(),
        ];

        return view('student.applications', compact('applications', 'counts'));
    }

    public function withdraw(JobApplication $application): RedirectResponse
    {
        // Authorize student
        abort_unless($application->student_id === auth()->id(), 403);

        $oldStatus = $application->status;
        $application->update(['status' => 'Withdrawn']);

        // Dispatch status change notification
        auth()->user()->notify(new ApplicationStatusChanged($application, $oldStatus, 'Withdrawn'));

        return redirect()->route('student.applications')->with('status', 'application-withdrawn');
    }

    public function employerApplicants(Request $request): View
    {
        $query = JobApplication::with(['student.studentProfile', 'jobListing'])
            ->whereHas('jobListing', function ($query) {
                $query->where('user_id', auth()->id());
            });

        // Filter by job listing if requested
        if ($request->filled('job_id')) {
            $query->where('job_listing_id', $request->input('job_id'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $applications = $query->latest()->paginate(10)->withQueryString();
        
        $jobs = JobListing::where('user_id', auth()->id())->get();

        return view('employer.applicants', compact('applications', 'jobs'));
    }

    public function employerApplicantDetails(JobApplication $application): View
    {
        abort_unless($application->jobListing->user_id === auth()->id(), 403);
        $application->load([
            'student.studentProfile',
            'student.studentProfile.skills',
            'student.studentProfile.latestResume.latestReview',
            'jobListing',
        ]);

        return view('employer.applicant-details', compact('application'));
    }

    public function employerUpdateStatus(Request $request, JobApplication $application): RedirectResponse
    {
        abort_unless($application->jobListing->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:Applied,Under Review,Shortlisted,Interview,Rejected,Hired'],
        ]);

        $oldStatus = $application->status;
        $newStatus = $validated['status'];

        if ($oldStatus !== $newStatus) {
            $application->update(['status' => $newStatus]);

            // Notify Student of status change
            $application->student->notify(new ApplicationStatusChanged($application, $oldStatus, $newStatus));
        }

        return redirect()->route('employer.applicant-details', $application)->with('status', 'status-updated');
    }

    /**
     * Employer submits/updates a resume review for this applicant.
     */
    public function employerReviewResume(Request $request, JobApplication $application): RedirectResponse
    {
        abort_unless($application->jobListing->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'overall_score' => ['required', 'integer', 'min:0', 'max:100'],
            'feedback' => ['required', 'string', 'max:3000'],
        ]);

        $resume = $application->student->studentProfile?->latestResume;

        abort_unless($resume, 404, 'This applicant has not uploaded a resume yet.');

        ResumeReview::create([
            'resume_id' => $resume->id,
            'reviewed_by' => auth()->id(),
            'overall_score' => $validated['overall_score'],
            'feedback' => $validated['feedback'],
            'reviewed_at' => now(),
        ]);

        $resume->update(['status' => 'reviewed']);

        return redirect()->route('employer.applicant-details', $application)->with('status', 'review-submitted');
    }
}