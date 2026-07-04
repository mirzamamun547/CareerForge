<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $profile = Auth::user()->studentProfile;
        $skills = $profile ? $profile->skills()->latest()->get() : collect();

        $counts = [
            'total' => $skills->count(),
            'expert' => $skills->where('level', 'Expert')->count(),
            'advanced' => $skills->where('level', 'Advanced')->count(),
            'intermediate' => $skills->where('level', 'Intermediate')->count(),
            'beginner' => $skills->where('level', 'Beginner')->count(),
        ];

        return view('student.skills', compact('skills', 'counts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'level' => ['required', 'in:Beginner,Intermediate,Advanced,Expert'],
            'proficiency' => ['required', 'integer', 'min:10', 'max:100'],
        ]);

        $profile = Auth::user()->studentProfile;

        if (! $profile) {
            $profile = Auth::user()->studentProfile()->create();
        }

        $profile->skills()->create($validated);

        return redirect()->route('student.skills')->with('status', 'skill-added');
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        // Ensure the skill belongs to the current user
        abort_unless(
            $skill->studentProfile->user_id === Auth::id(),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'level' => ['required', 'in:Beginner,Intermediate,Advanced,Expert'],
            'proficiency' => ['required', 'integer', 'min:10', 'max:100'],
        ]);

        $skill->update($validated);

        return redirect()->route('student.skills')->with('status', 'skill-updated');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        abort_unless(
            $skill->studentProfile->user_id === Auth::id(),
            403
        );

        $skill->delete();

        return redirect()->route('student.skills')->with('status', 'skill-deleted');
    }
}
