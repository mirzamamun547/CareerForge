@extends('layouts.student')

@section('title', 'Resume Review')
@section('header_title', 'Resume Review')
@section('header_subtitle', 'Get instant AI insights and manual reviews from recruiters.')

@push('styles')
<style>
    .score-ring-wrap {
        position: relative;
        width: 110px;
        height: 110px;
        flex-shrink: 0;
    }
    .score-ring-wrap svg {
        transform: rotate(-90deg);
    }
    .score-ring-wrap .score-center {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        line-height: 1.1;
    }
    .score-center .score-num {
        font-size: 1.65rem;
        font-weight: 800;
        color: #2D3142;
    }
    .score-center .score-sub {
        font-size: 0.65rem;
        color: #9CA3AF;
        font-weight: 600;
    }
    .feedback-box {
        font-size: 0.85rem;
        color: #4B5563;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 0.75rem;
        padding: 1.25rem;
        white-space: pre-line;
        line-height: 1.7;
    }
    .divider { border: none; border-top: 1px solid #F3F4F6; margin: 1.5rem 0; }
    .resume-file-chip {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 0.75rem;
    }
    .nav-tabs-custom {
        border-bottom: 2px solid #F3F4F6;
    }
    .nav-tabs-custom .nav-link {
        color: #6B7280;
        border: none;
        background: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border-radius: 0;
    }
    .nav-tabs-custom .nav-link:hover {
        color: #4F46E5;
    }
    .nav-tabs-custom .nav-link.active {
        color: #4F46E5;
        border-bottom-color: #4F46E5;
        background: none;
    }
    .nav-tabs-custom .nav-link i {
        font-size: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        {{-- Left: Reviews (AI and Human separated) --}}
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4">
                
                {{-- Tabs Header --}}
                <ul class="nav nav-tabs nav-tabs-custom mb-4 gap-2" id="reviewTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center gap-2" id="human-tab" data-bs-toggle="tab" data-bs-target="#human-review" type="button" role="tab" aria-controls="human-review" aria-selected="true">
                            <i class="bi bi-person-badge-fill"></i> Recruiter Review
                            @if($manualReview)
                                <span class="badge rounded-pill bg-emerald-soft text-emerald ms-1" style="font-size: 0.65rem;">Reviewed</span>
                            @else
                                <span class="badge rounded-pill bg-light text-secondary ms-1" style="font-size: 0.65rem;">Pending</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2" id="ai-tab" data-bs-toggle="tab" data-bs-target="#ai-review" type="button" role="tab" aria-controls="ai-review" aria-selected="false">
                            <i class="bi bi-stars" style="color: #4F46E5;"></i> AI Review
                            @if($aiReview)
                                <span class="badge rounded-pill bg-indigo-soft text-indigo ms-1" style="font-size: 0.65rem;">Available</span>
                            @else
                                <span class="badge rounded-pill bg-light text-secondary ms-1" style="font-size: 0.65rem;">Not Run</span>
                            @endif
                        </button>
                    </li>
                </ul>

                {{-- Tabs Content --}}
                <div class="tab-content" id="reviewTabsContent">
                    
                    {{-- 1. Recruiter Review Tab --}}
                    <div class="tab-pane fade show active" id="human-review" role="tabpanel" aria-labelledby="human-tab">
                        @if($manualReviews->count() > 0)
                            <div class="d-flex flex-column gap-4">
                                @foreach($manualReviews as $review)
                                    <div class="p-3.5 rounded-4 border border-light-subtle bg-light bg-opacity-50">
                                        <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                                            <div class="score-ring-wrap" style="width: 80px; height: 80px;">
                                                <svg width="80" height="80" viewBox="0 0 110 110">
                                                    <circle cx="55" cy="55" r="47" fill="none" stroke="#E5E7EB" stroke-width="9"/>
                                                    <circle cx="55" cy="55" r="47" fill="none" stroke="#10B981" stroke-width="9"
                                                        stroke-linecap="round"
                                                        stroke-dasharray="295"
                                                        stroke-dashoffset="{{ 295 - (295 * $review->overall_score / 100) }}"/>
                                                </svg>
                                                <div class="score-center">
                                                    <div class="score-num" style="font-size: 1.3rem;">{{ $review->overall_score }}</div>
                                                    <div class="score-sub" style="font-size: 0.55rem;">/100</div>
                                                </div>
                                            </div>

                                            <div>
                                                <h5 class="fw-bold text-dark mb-1" style="font-size:0.95rem;">
                                                    @if($review->reviewer && $review->reviewer->role === 'employer')
                                                        Review from {{ $review->reviewer->employerProfile?->company_name ?? $review->reviewer->name }}
                                                    @else
                                                        Review from CareerForge Recruiter
                                                    @endif
                                                </h5>
                                                <div class="mb-2">
                                                    <span class="badge-custom-emerald" style="font-size:0.65rem; padding:0.25em 0.7em;">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        {{ $review->reviewer && $review->reviewer->role === 'employer' ? 'Employer Feedback' : 'Official Review' }}
                                                    </span>
                                                </div>
                                                <p class="text-secondary mb-0" style="font-size:0.72rem;">
                                                    Submitted on {{ $review->reviewed_at?->format('d M Y, h:i A') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="feedback-box bg-white border border-light-subtle py-2.5 px-3 mb-0" style="font-size: 0.8rem; line-height: 1.6;">{{ $review->feedback }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="icon-shape mx-auto mb-3" style="width:60px; height:60px; background:#F3F4F6; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-hourglass-split text-secondary" style="font-size:1.6rem;"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size:0.95rem;">Waiting for Recruiter Review</h6>
                                <p class="text-secondary mb-0 mx-auto" style="font-size:0.82rem; max-width:400px;">
                                    Our admins and partner employers will review your resume shortly. You'll receive feedback and scores here once completed.
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- 2. AI Review Tab --}}
                    <div class="tab-pane fade" id="ai-review" role="tabpanel" aria-labelledby="ai-tab">
                        @if($aiReview)
                            <div class="d-flex align-items-center gap-4 mb-4">
                                <div class="score-ring-wrap">
                                    <svg width="110" height="110" viewBox="0 0 110 110">
                                        <circle cx="55" cy="55" r="47" fill="none" stroke="#E5E7EB" stroke-width="9"/>
                                        <circle cx="55" cy="55" r="47" fill="none" stroke="#4F46E5" stroke-width="9"
                                            stroke-linecap="round"
                                            stroke-dasharray="295"
                                            stroke-dashoffset="{{ 295 - (295 * $aiReview->overall_score / 100) }}"/>
                                    </svg>
                                    <div class="score-center">
                                        <div class="score-num">{{ $aiReview->overall_score }}</div>
                                        <div class="score-sub">/100</div>
                                    </div>
                                </div>

                                <div>
                                    <h5 class="fw-bold text-dark mb-1" style="font-size:1.05rem;">Gemini AI Score</h5>
                                    <div class="mb-2">
                                        <span class="badge-custom-indigo" style="font-size:0.72rem; padding:0.3em 0.8em;">
                                            <i class="bi bi-stars me-1"></i>Instant AI Review
                                        </span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size:0.78rem;">
                                        Generated on {{ $aiReview->reviewed_at?->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div>
                                <h6 class="fw-bold text-dark mb-3" style="font-size:0.88rem;">
                                    <i class="bi bi-chat-square-text-fill me-2" style="color:#4F46E5;"></i>AI Feedback & Suggestions
                                </h6>
                                <div class="feedback-box">{{ $aiReview->feedback }}</div>
                            </div>

                            <div class="divider"></div>

                            {{-- Re-run AI review button --}}
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-4">
                                <div class="text-secondary" style="font-size:0.75rem;">
                                    Want to run the analysis again? Re-uploading a new resume is recommended.
                                </div>
                                <form action="{{ route('student.resume-review.ai') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                        <i class="bi bi-arrow-clockwise"></i> Re-run AI Analysis
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="icon-shape mx-auto mb-3" style="width:60px; height:60px; background:#EEF2FF; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-stars" style="font-size:1.6rem; color:#4F46E5;"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size:0.95rem;">Get Instant AI Feedback</h6>
                                <p class="text-secondary mb-4 mx-auto" style="font-size:0.82rem; max-width:400px;">
                                    Don't wait! Get an immediate comprehensive AI critique of your resume structure, strengths, and areas of improvement powered by Gemini.
                                </p>
                                @if($latestResume)
                                    <form action="{{ route('student.resume-review.ai') }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2">
                                            <i class="bi bi-stars"></i> Generate AI Review Now
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('student.resume') }}" class="btn btn-primary-custom">
                                        Upload Resume First
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>

        {{-- Right Column: Resume File & Actions --}}
        <div class="col-12 col-lg-4 d-flex flex-column gap-4">

            {{-- Uploaded Resume Details --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3" style="font-size:0.9rem;">
                    <i class="bi bi-file-earmark-text me-2" style="color:#4F46E5;"></i>
                    Active Resume
                </h6>
                @if($latestResume)
                    <div class="resume-file-chip mb-3">
                        <div class="icon-shape flex-shrink-0" style="background-color:#EEF2FF;">
                            <i class="bi bi-file-earmark-pdf" style="font-size:1.1rem; color:#4F46E5;"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-dark text-truncate" style="font-size:0.88rem;">{{ basename($latestResume->file_path) }}</div>
                            <div class="text-secondary" style="font-size:0.7rem;">Uploaded: {{ $latestResume->created_at->format('d M Y') }}</div>
                        </div>
                        <a href="{{ route('student.resume.download') }}" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>

                    <a href="{{ route('student.resume') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2" style="font-size:0.82rem; border-radius:0.5rem; padding:0.6rem;">
                        <i class="bi bi-upload"></i> Upload New Version
                    </a>
                @else
                    <div class="text-center py-4 bg-light rounded-4">
                        <i class="bi bi-file-earmark-arrow-up text-secondary" style="font-size:1.5rem;"></i>
                        <p class="text-secondary mb-3 mt-1" style="font-size:0.78rem;">No resume uploaded yet.</p>
                        <a href="{{ route('student.resume') }}" class="btn btn-sm btn-primary-custom px-4">
                            Upload Now
                        </a>
                    </div>
                @endif
            </div>

            {{-- Tips Card --}}
            <div class="card border-0 p-4 rounded-4" style="background: linear-gradient(135deg, #4F46E5, #3730A3); color: white;">
                <h6 class="fw-bold mb-2 d-flex align-items-center gap-2" style="font-size:0.9rem;">
                    <i class="bi bi-lightbulb"></i> Pro Tips
                </h6>
                <ul class="ps-3 mb-0" style="font-size:0.76rem; opacity:0.9; line-height:1.6;">
                    <li class="mb-2"><strong>Get AI Review</strong> to instantly optimize your language, verbs, and keywords before recruiters look at it.</li>
                    <li><strong>Recruiter reviews</strong> are completed manually by admins and company talent teams who view your profile.</li>
                    <li>Your latest resume is the active one shared with job postings. Keep it up to date!</li>
                </ul>
            </div>

        </div>

    </div>
</div>
@endsection