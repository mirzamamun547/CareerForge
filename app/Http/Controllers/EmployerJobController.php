<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployerJobController extends Controller
{
    public function create(): View
    {
        return view('employer.jobs');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'category' => ['required','string','max:255'],
            'job_type' => ['required','string','max:255'],
            'location' => ['required','string','max:255'],
            'min_salary' => ['required','integer','min:0'],
            'max_salary' => ['required','integer','min:0'],
            'description' => ['required','string'],
            'status' => ['nullable','string','max:50'],
        ]);

        $request->user()->jobListings()->create($validated);

        return redirect()->route('employer.manage-jobs')->with('success', 'Job posted successfully.');
    }

    public function index(): View
    {
        $jobs = auth()->user()->jobListings()->latest()->get();

        return view('employer.manage-jobs', compact('jobs'));
    }

    public function update(Request $request, JobListing $job): RedirectResponse
    {
        abort_unless($job->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'category' => ['required','string','max:255'],
            'job_type' => ['required','string','max:255'],
            'location' => ['required','string','max:255'],
            'min_salary' => ['required','integer','min:0'],
            'max_salary' => ['required','integer','min:0'],
            'description' => ['required','string'],
            'status' => ['nullable','string','max:50'],
        ]);

        $job->update($validated);

        return back()->with('success', 'Job updated successfully.');
    }
}
