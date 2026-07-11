<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureResumeUploaded
{
    /**
     * Block access to the job application form/submission unless the
     * student has uploaded at least one resume. Without this, a student
     * could apply to jobs with no resume on file for the employer to review.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = $request->user()->studentProfile;

        if (! $profile || ! $profile->latestResume) {
            return redirect()
                ->route('student.resume')
                ->with('error', 'Please upload your resume before applying to a job.');
        }

        return $next($request);
    }
}