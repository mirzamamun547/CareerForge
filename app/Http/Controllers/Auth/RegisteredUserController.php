<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployerProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the role-selection view (entry point for /register).
     */
    public function create(): View
    {
        return view('auth.select-role');
    }

    /**
     * Handle an incoming registration request from either the
     * student or employer registration form.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role', 'student');

        if (! in_array($role, ['student', 'employer'], true)) {
            throw ValidationException::withMessages([
                'role' => 'Invalid registration role.',
            ]);
        }

        return $role === 'employer'
            ? $this->storeEmployer($request)
            : $this->storeStudent($request);
    }

    /**
     * Validate and create a student account + student_profiles row.
     */
    protected function storeStudent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'phone' => ['required', 'string', 'max:30'],
            'university' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'graduation_year' => ['required', 'integer', 'digits:4'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);

        $profilePicturePath = $request->hasFile('profile_picture')
            ? $request->file('profile_picture')->store('profile-pictures', 'public')
            : null;

        $user = DB::transaction(function () use ($validated, $profilePicturePath) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'profile_picture' => $profilePicturePath,
                'university' => $validated['university'],
                'department' => $validated['department'],
                'graduation_year' => $validated['graduation_year'],
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect($user->dashboardRoute());
    }

    /**
     * Validate and create an employer account + employer_profiles row.
     */
    protected function storeEmployer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'website' => ['nullable', 'url', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string'],
            'contact_person' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
            'company_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $companyLogoPath = $request->hasFile('company_logo')
            ? $request->file('company_logo')->store('company-logos', 'public')
            : null;

        $user = DB::transaction(function () use ($validated, $companyLogoPath) {
            $user = User::create([
                'name' => $validated['contact_person'],
                'email' => $validated['company_email'],
                'password' => Hash::make($validated['password']),
                'role' => 'employer',
                'phone' => $validated['phone'],
            ]);

            EmployerProfile::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'],
                'company_email' => $validated['company_email'],
                'website' => $validated['website'] ?? null,
                'industry' => $validated['industry'],
                'company_address' => $validated['company_address'],
                'contact_person' => $validated['contact_person'],
                'company_logo' => $companyLogoPath,
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect($user->dashboardRoute());
    }
}
