<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\SkillMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployerJobController extends Controller
{
    public function create(): View
    {
        $skillSuggestions = SkillMaster::orderBy('name')->pluck('name');

        return view('employer.jobs', compact('skillSuggestions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'category' => ['required','string','max:255'],
            'job_type' => ['required','string','max:255'],
            'location' => ['required','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'country' => ['nullable','string','max:255'],
            'latitude' => ['nullable','numeric'],
            'longitude' => ['nullable','numeric'],
            'level' => ['nullable','string','max:255'],
            'min_salary' => ['required','integer','min:0'],
            'max_salary' => ['required','integer','min:0'],
            'deadline' => ['nullable','date'],
            'skills' => ['nullable','string'],
            'description' => ['required','string'],
            'requirements' => ['nullable','string'],
            'benefits' => ['nullable','array'],
            'status' => ['nullable','string','max:50'],
        ]);

        $validated['benefits'] = ! empty($validated['benefits']) ? implode(', ', $validated['benefits']) : null;

        $request->user()->jobListings()->create($validated)->syncSkillsFromText();

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
            'city' => ['nullable','string','max:255'],
            'country' => ['nullable','string','max:255'],
            'latitude' => ['nullable','numeric'],
            'longitude' => ['nullable','numeric'],
            'level' => ['nullable','string','max:255'],
            'min_salary' => ['required','integer','min:0'],
            'max_salary' => ['required','integer','min:0'],
            'deadline' => ['nullable','date'],
            'skills' => ['nullable','string'],
            'description' => ['required','string'],
            'requirements' => ['nullable','string'],
            'benefits' => ['nullable','array'],
            'status' => ['nullable','string','max:50'],
        ]);

        $validated['benefits'] = ! empty($validated['benefits']) ? implode(', ', $validated['benefits']) : null;

        $job->update($validated);
        $job->syncSkillsFromText();

        return back()->with('success', 'Job updated successfully.');
    }

    public function editCompanyProfile(): View
    {
        $user = auth()->user();
        $profile = $user->employerProfile ?? new \App\Models\EmployerProfile();
        return view('employer.company-profile', compact('profile', 'user'));
    }

    public function updateCompanyProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $profile = $user->employerProfile ?? new \App\Models\EmployerProfile(['user_id' => $user->id]);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
            'company_address' => ['nullable', 'string'],
            'industry' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->update([
            'phone' => $validated['phone'],
        ]);

        if ($request->hasFile('company_logo')) {
            if ($profile->company_logo && \Storage::disk('public')->exists($profile->company_logo)) {
                \Storage::disk('public')->delete($profile->company_logo);
            }
            $logoPath = $request->file('company_logo')->store('company-logos', 'public');
            $profile->company_logo = $logoPath;
        }

        $profile->fill([
            'company_name' => $validated['company_name'],
            'company_email' => $validated['company_email'],
            'website' => $validated['website'],
            'company_address' => $validated['company_address'],
            'industry' => $validated['industry'],
            'contact_person' => $validated['contact_person'],
        ]);
        $profile->save();

        return back()->with('success', 'Company profile updated successfully.');
    }
}