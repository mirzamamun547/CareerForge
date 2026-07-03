<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStudentProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    /**
     * Display the student profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user()->load('studentProfile');
        return view('student.profile', compact('user'));
    }

    /**
     * Update the student profile details.
     */
    public function update(UpdateStudentProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        DB::transaction(function () use ($user, $request, $validated) {
            // Update User properties
            $user->update([
                'name' => $validated['name'],
            ]);

            // Retrieve or create Student Profile
            $profile = $user->studentProfile ?: $user->studentProfile()->create();

            $profileData = [
                'phone' => $validated['phone'],
                'university' => $validated['university'],
                'department' => $validated['department'],
                'graduation_year' => $validated['graduation_year'],
            ];

            // Handle Profile Picture upload
            if ($request->hasFile('profile_picture')) {
                if ($profile->profile_picture) {
                    Storage::disk('public')->delete($profile->profile_picture);
                }
                $profileData['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
            }

            $profile->update($profileData);
        });

        return redirect()->route('student.profile')->with('status', 'profile-updated');
    }
}
