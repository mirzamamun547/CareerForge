@extends('layouts.student')

@section('title', 'Resume Review')
@section('header_title', 'Resume Review')
@section('header_subtitle', 'Feedback from employers/admins on your uploaded resume.')

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
    .review-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.3em 0.9em;
        border-radius: 50rem;
    }
    .feedback-box {
        font-size: 0.85rem;
        color: #4B5563;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 0.75rem;
        padding: 1rem 1.1rem;
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
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        {{-- Left: Score + Feedback --}}
        <div class="col-12 col-lg-7">
            <div class="card card-custom p-4 h-100">

                @if($latestReview)
                    {{-- Score Header --}}
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <div class="score-ring-wrap">
                            <svg width="110" height="110" viewBox="0 0 110 110">
                                <circle cx="55" cy="55" r="47" fill="none" stroke="#E5E7EB" stroke-width="9"/>
                                <circle cx="55" cy="55" r="47" fill="none" stroke="#4F46E5" stroke-width="9"
                                    stroke-linecap="round"
                                    stroke-dasharray="295"
                                    stroke-dashoffset="{{ 295 - (295 * ($latestReview->overall_score ?? 0) / 100) }}"/>
                            </svg>
                            <div class="score-center">
                                <div class="score-num">{{ $latestReview->overall_score ?? '-' }}</div>
                                <div class="score-sub">/100</div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="fw-bold text-dark m-0" style="font-size:1.05rem;">Overall Score</h5>
                            </div>
                            <div class="mb-1 d-flex gap-2">
                                <span class="badge-custom-emerald" style="font-size:0.72rem; padding:0.3em 0.8em;">
                                    <i class="bi bi-check-circle me-1"></i>Reviewed
                                </span>
                                @if(($latestReview->source ?? 'manual') === 'ai')
                                    <span class="badge-custom-indigo" style="font-size:0.72rem; padding:0.3em 0.8em;">
                                        <i class="bi bi-stars me-1"></i>AI Review
                                    </span>
                                @endif
                            </div>
                            <p class="text-secondary mb-0 mt-2" style="font-size:0.78rem;">
                                Reviewed on {{ $latestReview->reviewed_at?->format('d M Y') }}
                                @if($latestReview->reviewer)
                                    by {{ $latestReview->reviewer->name }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- Feedback --}}
                    <div>
                        <h6 class="fw-bold text-dark mb-3" style="font-size:0.88rem;">
                            <i class="bi bi-chat-square-text-fill me-2" style="color:#4F46E5;"></i>Feedback
                        </h6>
                        <div class="feedback-box">{{ $latestReview->feedback }}</div>
                    </div>
                @else
                    {{-- Empty state: no review yet --}}
                    <div class="text-center py-5">
                        <i class="bi bi-hourglass-split" style="font-size:2.2rem; color:#9CA3AF;"></i>
                        <h6 class="fw-bold text-dark mt-3 mb-1" style="font-size:0.95rem;">Not Reviewed Yet</h6>
                        <p class="text-secondary mb-0" style="font-size:0.82rem;">
                            @if($latestResume)
                                Your resume is uploaded and waiting to be reviewed by an employer or admin.
                            @else
                                Upload a resume first to get it reviewed.
                            @endif
                        </p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Right: Resume + Re-upload --}}
        <div class="col-12 col-lg-5 d-flex flex-column gap-4">

            {{-- Uploaded Resume --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3" style="font-size:0.9rem;">
                    <i class="bi bi-file-earmark-text me-2" style="color:#4F46E5;"></i>
                    {{ $latestReview ? 'Reviewed Resume' : 'Uploaded Resume' }}
                </h6>
                @if($latestResume)
                    <div class="resume-file-chip">
                        <div class="icon-shape flex-shrink-0" style="background-color:#EEF2FF;">
                            <i class="bi bi-file-earmark-pdf" style="font-size:1.1rem; color:#4F46E5;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark" style="font-size:0.88rem;">{{ basename($latestResume->file_path) }}</div>
                            <div class="text-secondary" style="font-size:0.7rem;">Uploaded: {{ $latestResume->created_at->format('d M Y') }}</div>
                        </div>
                        <a href="{{ route('student.resume.download') }}" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center gap-1" style="font-size:0.75rem;">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                @else
                    <p class="text-secondary mb-0" style="font-size:0.82rem;">No resume uploaded yet.</p>
                @endif
            </div>

            {{-- AI Review --}}
            @if($latestResume)
                <div class="card card-custom p-4">
                    <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;">
                        <i class="bi bi-stars me-2" style="color:#4F46E5;"></i>Instant AI Review
                    </h6>
                    <p class="text-secondary mb-3" style="font-size:0.78rem;">
                        Get instant feedback from Gemini AI while you wait for a human reviewer.
                    </p>
                    <form action="{{ route('student.resume-review.ai') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2 w-100">
                            <i class="bi bi-stars"></i> Get AI Review
                        </button>
                    </form>
                </div>
            @endif

            {{-- Re-upload --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;">
                    <i class="bi bi-arrow-repeat me-2" style="color:#10B981;"></i>
                    {{ $latestResume ? 'Re-upload Resume' : 'Upload Resume' }}
                </h6>
                <p class="text-secondary mb-3" style="font-size:0.78rem;">
                    @if($latestResume)
                        Upload an improved version to get a fresh review.
                    @else
                        Upload your resume so employers can review it.
                    @endif
                </p>
                <a href="{{ route('student.resume') }}" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-upload"></i> {{ $latestResume ? 'Upload New Version' : 'Upload Resume' }}
                </a>
            </div>

        </div>

    </div>
</div>
@endsection