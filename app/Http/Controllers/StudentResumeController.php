<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadResumeRequest;
use App\Models\Resume;
use App\Models\ResumeReview;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;
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
        $latestResume = $profile ? $profile->latestResume()->first() : null;
        
        $aiReview = $latestResume ? $latestResume->aiReview()->first() : null;
        $manualReviews = $latestResume ? $latestResume->reviews()->where('source', 'manual')->with('reviewer')->latest('reviewed_at')->get() : collect();
        $manualReview = $manualReviews->first();

        return view('student.resume-review', compact('latestResume', 'aiReview', 'manualReview', 'manualReviews'));
    }

    /**
     * Ask Gemini (via Guzzle, called directly here) to review the student's
     * latest resume and store the result as a ResumeReview row with
     * source = 'ai'.
     */
    public function requestAiReview(): RedirectResponse
    {
        $profile = Auth::user()->studentProfile;
        $latestResume = $profile ? $profile->latestResume : null;

        if (! $latestResume) {
            return redirect()->route('student.resume')
                ->with('error', 'Please upload a resume first.');
        }

        // --- 1. Make sure the file is a PDF and exists on disk ---
        if (! Storage::disk('public')->exists($latestResume->file_path)) {
            return redirect()->route('student.resume-review')
                ->with('error', 'Resume file not found on disk.');
        }

        $extension = strtolower(pathinfo($latestResume->file_path, PATHINFO_EXTENSION));

        if ($extension !== 'pdf') {
            return redirect()->route('student.resume-review')
                ->with('error', 'AI review currently only supports PDF resumes. Please re-upload your resume as a PDF.');
        }

        // --- 2. Extract text from the PDF using smalot/pdfparser ---
        try {
            $absolutePath = Storage::disk('public')->path($latestResume->file_path);
            $parser = new PdfParser();
            $resumeText = $parser->parseFile($absolutePath)->getText();
        } catch (\Throwable $e) {
            return redirect()->route('student.resume-review')
                ->with('error', 'Could not read the PDF: ' . $e->getMessage());
        }

        if (trim($resumeText) === '') {
            return redirect()->route('student.resume-review')
                ->with('error', 'Could not extract any text from this resume file.');
        }

        // --- 3. Build the prompt ---
        $prompt = <<<PROMPT
        You are an expert technical recruiter reviewing a candidate's resume.
        Below is the raw text extracted from the candidate's resume. Read it and
        respond with ONLY a JSON object (no markdown, no code fences) in exactly
        this shape:

        {
          "overall_score": <integer 0-100>,
          "feedback": "<3-5 sentences covering strengths, weaknesses, and concrete suggestions for improvement>"
        }

        Resume text:
        ---
        {$resumeText}
        ---
        PROMPT;

        // --- 4. Call Gemini with model fallback + retry-on-503 ---
        $result = $this->generateWithGemini($prompt);

        if (isset($result['error'])) {
            return redirect()->route('student.resume-review')
                ->with('error', 'AI review failed (' . ($result['status'] ?? 'unknown') . '): ' . $result['error']);
        }

        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (! $text) {
            return redirect()->route('student.resume-review')
                ->with('error', 'Gemini returned an unexpected response format.');
        }

        // Gemini sometimes wraps JSON in ```json fences even when asked not to;
        // strip those defensively before decoding.
        $clean = trim(preg_replace('/^```json|```$/m', '', $text));
        $parsed = json_decode($clean, true);

        if (! isset($parsed['overall_score'], $parsed['feedback'])) {
            return redirect()->route('student.resume-review')
                ->with('error', "Could not parse Gemini's JSON output.");
        }

        // --- 5. Save the AI review ---
        ResumeReview::create([
            'resume_id' => $latestResume->id,
            'reviewed_by' => null,
            'source' => 'ai',
            'overall_score' => (int) max(0, min(100, $parsed['overall_score'])),
            'feedback' => (string) $parsed['feedback'],
            'reviewed_at' => now(),
        ]);

        $latestResume->update(['status' => 'reviewed']);

        return redirect()->route('student.resume-review')
            ->with('status', 'Your resume has been reviewed by AI (model: ' . ($result['_model_used'] ?? '?') . ').');
    }

    /**
     * Core Gemini call: tries a primary model, falls back through a list of
     * alternative models, and retries up to 3 times on 503 (server overload).
     * Quotas are per-model, so falling back to another model also helps
     * when one model returns 429 (quota exceeded).
     */
    protected function generateWithGemini(string $prompt): array
    {
        $primaryModel = 'gemini-2.5-flash';
        $fallbackModels = [
            'gemini-2.0-flash',
            'gemini-2.0-flash-lite',
            'gemini-flash-lite-latest',
        ];

        $modelsToTry = array_merge([$primaryModel], $fallbackModels);
        $apiKey = config('services.gemini.api_key');
        $client = new Client(['timeout' => 30]);
        $lastError = [];

        foreach ($modelsToTry as $model) {
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                try {
                    $response = $client->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                        [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'X-goog-api-key' => $apiKey,
                            ],
                            'json' => [
                                'contents' => [
                                    ['parts' => [['text' => $prompt]]],
                                ],
                                'generationConfig' => [
                                    'response_mime_type' => 'application/json',
                                ],
                            ],
                        ]
                    );

                    $data = json_decode($response->getBody()->getContents(), true);
                    $data['_model_used'] = $model;

                    return $data;
                } catch (\Exception $e) {
                    $status = method_exists($e, 'getResponse') && $e->getResponse()
                        ? $e->getResponse()->getStatusCode()
                        : 500;

                    $lastError = [
                        'error' => $e->getMessage(),
                        'status' => $status,
                        'model' => $model,
                        'attempt' => $attempt,
                    ];

                    // Only retry the same model on 503 (temporary overload).
                    if ($status === 503 && $attempt < 3) {
                        sleep(2);
                        continue;
                    }

                    // Any other status (e.g. 429 quota) — stop retrying this
                    // model and move straight to the next one in the list.
                    break;
                }
            }
        }

        return $lastError;
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