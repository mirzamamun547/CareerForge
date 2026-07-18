<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    // Primary model — confirmed available via ListModels API
    private string $model = 'gemini-2.5-flash';

    // Fallback models tried in order if primary returns 503 (all confirmed available)
    private array $fallbackModels = [
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-flash-lite-latest',  // alias, always points to latest lite
    ];

    /**
     * Quick test route: GET /gemini/test
     * Verifies the API key and connection are working.
     */
    public function test()
    {
        $result = $this->generate('Say hello in one sentence.');

        if (isset($result['error'])) {
            return response()->json($result, $result['status'] ?? 500);
        }

        return response()->json([
            'status' => 'ok',
            'model'  => $result['_model_used'] ?? $this->model,
            'reply'  => $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text',
        ]);
    }

    /**
     * POST /gemini/generate
     * Body: { "prompt": "..." }
     * Returns AI-generated text for the given prompt.
     */
    public function generateFromRequest(Request $request)
    {
        $request->validate(['prompt' => 'required|string|max:2000']);

        $result = $this->generate($request->input('prompt'));

        if (isset($result['error'])) {
            return response()->json($result, $result['status'] ?? 500);
        }

        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return response()->json(['reply' => $text]);
    }

    /**
     * Core method: send a prompt to Gemini with retry + model fallback.
     *
     * - Retries up to 3 times on 503 (server overload) with 2s delay between attempts
     * - Falls back to alternative models if all retries fail on a given model
     * - Uses X-goog-api-key header (required for AQ. auth keys from AI Studio)
     * - Returns array with 'error' key on complete failure
     */
    public function generate(string $prompt): array
    {
        $modelsToTry = array_merge([$this->model], $this->fallbackModels);
        $apiKey      = config('services.gemini.api_key');
        $client      = new Client(['timeout' => 30]);
        $lastError   = [];

        foreach ($modelsToTry as $model) {
            // Try each model up to 3 times on 503
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                try {
                    $response = $client->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                        [
                            'headers' => [
                                'Content-Type'   => 'application/json',
                                'X-goog-api-key' => $apiKey,  // Required for AQ. auth keys
                            ],
                            'json' => [
                                'contents' => [
                                    [
                                        'parts' => [
                                            ['text' => $prompt]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    );

                    $data = json_decode($response->getBody()->getContents(), true);
                    $data['_model_used'] = $model; // track which model succeeded
                    return $data;

                } catch (\Exception $e) {
                    $status = method_exists($e, 'getResponse') && $e->getResponse()
                        ? $e->getResponse()->getStatusCode()
                        : 500;

                    $body = null;
                    if (method_exists($e, 'getResponse') && $e->getResponse()) {
                        $body = json_decode($e->getResponse()->getBody()->getContents(), true);
                    }

                    $lastError = [
                        'error'   => $e->getMessage(),
                        'status'  => $status,
                        'body'    => $body,
                        'model'   => $model,
                        'attempt' => $attempt,
                    ];

                    // Only retry on 503 (overloaded) — not on 429 (quota) or 4xx errors
                    if ($status === 503 && $attempt < 3) {
                        sleep(2); // wait 2 seconds before retrying
                        continue;
                    }

                    // For non-503 errors, skip to next model immediately
                    break;
                }
            }
        }

        // All models and retries exhausted — return last error
        return $lastError;
    }
}