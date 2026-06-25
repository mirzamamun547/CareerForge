@extends('layouts.student')

@section('title', 'Resume Review')
@section('header_title', 'Resume Review')
@section('header_subtitle', 'AI-powered feedback on your uploaded resume.')

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
    .feedback-section { margin-bottom: 1.5rem; }
    .feedback-section h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: #2D3142;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .feedback-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem; }
    .feedback-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        font-size: 0.83rem;
        color: #4B5563;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 0.65rem;
        padding: 0.6rem 0.85rem;
    }
    .feedback-list li i { flex-shrink: 0; margin-top: 2px; }
    .strength-icon  { color: #10B981; }
    .weakness-icon  { color: #F43F5E; }
    .suggest-icon   { color: #4F46E5; }
    .step-icon   { color: #D97706; }
    .next-step-list li { background: #FEF3C7; border-color: #FDE68A; color: #92400E; }
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
    .score-meter {
        height: 8px;
        border-radius: 50rem;
        background: #E5E7EB;
        overflow: hidden;
        margin-top: 4px;
    }
    .score-meter-fill {
        height: 100%;
        border-radius: 50rem;
        transition: width 1.2s cubic-bezier(.4,0,.2,1);
    }
    .metric-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        {{-- Left: Score + Feedback --}}
        <div class="col-12 col-lg-7">
            <div class="card card-custom p-4 h-100">

                {{-- Score Header --}}
                <div class="d-flex align-items-center gap-4 mb-4">
                    {{-- SVG Ring --}}
                    <div class="score-ring-wrap">
                        <svg width="110" height="110" viewBox="0 0 110 110">
                            <circle cx="55" cy="55" r="47" fill="none" stroke="#E5E7EB" stroke-width="9"/>
                            <circle cx="55" cy="55" r="47" fill="none" stroke="#4F46E5" stroke-width="9"
                                stroke-linecap="round"
                                stroke-dasharray="295"
                                stroke-dashoffset="{{ 295 - (295 * 72 / 100) }}"/>
                        </svg>
                        <div class="score-center">
                            <div class="score-num">72</div>
                            <div class="score-sub">/100</div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold text-dark m-0" style="font-size:1.05rem;">Overall Score</h5>
                            <span class="review-badge" style="background:#EEF2FF; color:#4F46E5;">Junior Review</span>
                        </div>
                        <div class="mb-1">
                            <span class="badge-custom-emerald" style="font-size:0.72rem; padding:0.3em 0.8em;">
                                <i class="bi bi-check-circle me-1"></i>Reviewed
                            </span>
                        </div>
                        <p class="text-secondary mb-0 mt-2" style="font-size:0.78rem;">
                            Your resume has been analysed by our AI engine.<br>
                            Here's a detailed breakdown below.
                        </p>
                    </div>
                </div>

                {{-- Score Breakdown --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size:0.88rem;">
                        <i class="bi bi-bar-chart-fill me-2" style="color:#4F46E5;"></i>Score Breakdown
                    </h6>
                    @php
                        $metrics = [
                            ['label' => 'Content Quality',    'score' => 78, 'color' => '#4F46E5'],
                            ['label' => 'Formatting',         'score' => 85, 'color' => '#10B981'],
                            ['label' => 'Keywords Match',     'score' => 60, 'color' => '#D97706'],
                            ['label' => 'Skills Section',     'score' => 65, 'color' => '#F43F5E'],
                        ];
                    @endphp
                    <div class="d-flex flex-column gap-2">
                        @foreach($metrics as $m)
                        <div>
                            <div class="metric-row">
                                <span style="color:#4B5563;">{{ $m['label'] }}</span>
                                <span style="color:{{ $m['color'] }};">{{ $m['score'] }}%</span>
                            </div>
                            <div class="score-meter">
                                <div class="score-meter-fill" style="width:{{ $m['score'] }}%; background:{{ $m['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Strengths --}}
                <div class="feedback-section">
                    <h6><i class="bi bi-hand-thumbs-up-fill strength-icon"></i> Strengths</h6>
                    <ul class="feedback-list">
                        <li><i class="bi bi-check-circle-fill strength-icon"></i> Good terminal skills listed clearly</li>
                        <li><i class="bi bi-check-circle-fill strength-icon"></i> Clear and well-structured layout</li>
                        <li><i class="bi bi-check-circle-fill strength-icon"></i> Relevant work experience highlighted</li>
                    </ul>
                </div>

                {{-- Weaknesses --}}
                <div class="feedback-section">
                    <h6><i class="bi bi-exclamation-triangle-fill weakness-icon"></i> Weaknesses</h6>
                    <ul class="feedback-list">
                        <li><i class="bi bi-x-circle-fill weakness-icon"></i> Summary is too short</li>
                        <li><i class="bi bi-x-circle-fill weakness-icon"></i> No strong energy statement</li>
                        <li><i class="bi bi-x-circle-fill weakness-icon"></i> Skills section can be improved</li>
                    </ul>
                </div>

                {{-- Suggestions --}}
                <div class="feedback-section mb-0">
                    <h6><i class="bi bi-lightbulb-fill suggest-icon"></i> Suggestions</h6>
                    <ul class="feedback-list">
                        <li><i class="bi bi-arrow-right-circle-fill suggest-icon"></i> Add 2–3 strong projects with details</li>
                        <li><i class="bi bi-arrow-right-circle-fill suggest-icon"></i> Improve summary section</li>
                        <li><i class="bi bi-arrow-right-circle-fill suggest-icon"></i> Highlight key skills more prominently</li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Right: Resume + Next Steps --}}
        <div class="col-12 col-lg-5 d-flex flex-column gap-4">

            {{-- Uploaded Resume --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3" style="font-size:0.9rem;">
                    <i class="bi bi-file-earmark-text me-2" style="color:#4F46E5;"></i>Reviewed Resume
                </h6>
                <div class="resume-file-chip">
                    <div class="icon-shape flex-shrink-0" style="background-color:#EEF2FF;">
                        <i class="bi bi-file-earmark-pdf" style="font-size:1.1rem; color:#4F46E5;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark" style="font-size:0.88rem;">Raihan_Uddin_Resume.pdf</div>
                        <div class="text-secondary" style="font-size:0.7rem;">Uploaded: 12 May 2024 &bull; 249 KB</div>
                    </div>
                    <a href="#" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center gap-1" style="font-size:0.75rem;">
                        <i class="bi bi-download"></i>
                    </a>
                </div>
            </div>

            {{-- Next Steps --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3" style="font-size:0.9rem;">
                    <i class="bi bi-arrow-right-circle-fill me-2" style="color:#D97706;"></i>Next Steps
                </h6>
                <ul class="feedback-list next-step-list">
                    <li><i class="bi bi-1-circle-fill step-icon"></i> Add more projects</li>
                    <li><i class="bi bi-2-circle-fill step-icon"></i> Add a PDF/Canva resume</li>
                    <li><i class="bi bi-3-circle-fill step-icon"></i> Improve career summary</li>
                    <li><i class="bi bi-4-circle-fill step-icon"></i> Highlight top skills</li>
                </ul>
            </div>

            {{-- Re-upload --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;">
                    <i class="bi bi-arrow-repeat me-2" style="color:#10B981;"></i>Re-upload Resume
                </h6>
                <p class="text-secondary mb-3" style="font-size:0.78rem;">Upload an improved version to get a fresh review score.</p>
                <a href="/student/resume" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-upload"></i> Upload New Version
                </a>
            </div>

        </div>

    </div>
</div>
@endsection