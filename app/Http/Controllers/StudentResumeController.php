<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadResumeRequest;
use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class StudentResumeController extends Controller
{
    /**
     * Display the resume upload view.
     */
    public function edit(Request $request): View
    {
        $profile = Auth::user()->studentProfile;
        $latestResume = $profile ? $profile->latestResume : null;
        return view('student.resume', compact('latestResume'));
    }

    /**
     * Store/upload a new resume PDF/DOCX file.
     */
    public function store(UploadResumeRequest $request): RedirectResponse
    {
        $profile = Auth::user()->studentProfile ?: Auth::user()->studentProfile()->create();

        // 1. Delete old resume records and files if they exist
        $oldResumes = $profile->resumes;
        foreach ($oldResumes as $oldResume) {
            Storage::disk('public')->delete($oldResume->file_path);
            $oldResume->delete();
        }

        // 2. Upload new resume
        $path = $request->file('resume')->store('resumes', 'public');

        // 3. Save new path in resumes table
        Resume::create([
            'student_profile_id' => $profile->id,
            'file_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('student.resume')->with('status', 'resume-uploaded');
    }

    /**
     * Display the resume review results for the student's latest resume.
     */
    public function review(Request $request): View
    {
        $profile = Auth::user()->studentProfile;
        $latestResume = $profile ? $profile->latestResume()->with('latestReview')->first() : null;
        $latestReview = $latestResume ? $latestResume->latestReview : null;

        return view('student.resume-review', compact('latestResume', 'latestReview'));
    }

    /**
     * Securely download the student's own resume.
     */
    public function download(Request $request): StreamedResponse
    {
        $profile = Auth::user()->studentProfile;
        $latestResume = $profile ? $profile->latestResume : null;

        if (!$latestResume || !Storage::disk('public')->exists($latestResume->file_path)) {
            abort(404, 'Resume not found.');
        }

        return Storage::disk('public')->download(
            $latestResume->file_path,
            basename($latestResume->file_path)
        );
    }
}