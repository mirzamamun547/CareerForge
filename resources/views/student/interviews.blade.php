@extends('layouts.student')

@section('title', 'Interview Schedule')
@section('header_title', 'Interview Schedule')
@section('header_subtitle', 'Manage your upcoming and past interviews.')

@push('styles')
<style>
    .interview-card {
        border: 1px solid #E5E7EB;
        border-radius: 0.85rem;
        background: #fff;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow 0.2s, transform 0.18s;
    }
    .interview-card:hover {
        box-shadow: 0 6px 24px rgba(79,70,229,0.10);
        transform: translateY(-2px);
    }
    .company-avatar {
        width: 3rem; height: 3rem;
        border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; font-weight: 800;
        flex-shrink: 0;
    }
    .meta-chip {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.75rem; color: #6B7280; font-weight: 600;
    }
    .meta-chip i { color: #9CA3AF; font-size: 0.8rem; }
    .badge-online  { background:#ECFDF5; color:#10B981; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem; }
    .badge-onsite  { background:#EEF2FF; color:#4F46E5; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem; }
    .view-detail-btn {
        font-size: 0.8rem; font-weight: 700;
        padding: 0.5rem 1.1rem;
        border-radius: 0.6rem;
        background: #4F46E5; color: #fff;
        border: none; transition: background 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .view-detail-btn:hover { background: #4338CA; }
    .note-banner {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 0.75rem;
        padding: 0.85rem 1.1rem;
        font-size: 0.82rem;
        color: #92400E;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .section-label {
        font-size: 0.72rem; font-weight: 700; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.07em;
        margin-bottom: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0 d-flex flex-column gap-4">

    {{-- Upcoming Interviews --}}
    <div class="card card-custom p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-dark m-0" style="font-size:1rem;">
                <i class="bi bi-calendar2-week-fill me-2" style="color:#4F46E5;"></i>Upcoming Interviews
            </h5>
            <span class="badge-custom-indigo" style="font-size:0.72rem; padding:0.35em 0.85em;">2 Scheduled</span>
        </div>

        <div class="d-flex flex-column gap-3">

            {{-- Interview 1 --}}
            <div class="interview-card">
                <div class="company-avatar" style="background:#ECFDF5; color:#10B981;">CI</div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem;">Laravel Developer</h6>
                        <span class="badge-online">Online</span>
                    </div>
                    <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">Creative IT</div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="meta-chip"><i class="bi bi-calendar3"></i> 28 May 2024</span>
                        <span class="meta-chip"><i class="bi bi-clock"></i> 10:00 AM</span>
                        <span class="meta-chip"><i class="bi bi-camera-video"></i> Google Meet</span>
                    </div>
                </div>
                <button class="view-detail-btn">View Details</button>
            </div>

            {{-- Interview 2 --}}
            <div class="interview-card">
                <div class="company-avatar" style="background:#FEF3C7; color:#D97706;">SC</div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem;">PHP Developer</h6>
                        <span class="badge-onsite">On-Site</span>
                    </div>
                    <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">SoftCloud</div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="meta-chip"><i class="bi bi-calendar3"></i> 29 May 2024</span>
                        <span class="meta-chip"><i class="bi bi-clock"></i> 02:00 PM</span>
                        <span class="meta-chip"><i class="bi bi-geo-alt"></i> Dhaka Office</span>
                    </div>
                </div>
                <button class="view-detail-btn">View Details</button>
            </div>

        </div>

        {{-- Note Banner --}}
        <div class="note-banner mt-4">
            <i class="bi bi-info-circle-fill flex-shrink-0" style="color:#D97706;"></i>
            <span>Note: Please join the interview on time. Good luck!</span>
        </div>
    </div>

    {{-- Past Interviews --}}
    <div class="card card-custom p-4">
        <h5 class="fw-bold text-dark mb-4" style="font-size:1rem;">
            <i class="bi bi-clock-history me-2" style="color:#9CA3AF;"></i>Past Interviews
        </h5>

        <div class="d-flex flex-column gap-3">

            {{-- Past 1 --}}
            <div class="interview-card" style="opacity:0.7;">
                <div class="company-avatar" style="background:#F3F4F6; color:#6B7280;">BS</div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem;">Web Developer</h6>
                        <span class="status-badge" style="background:#F3F4F6; color:#6B7280; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem;">Completed</span>
                    </div>
                    <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">Brain Station 23</div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="meta-chip"><i class="bi bi-calendar3"></i> 15 Apr 2024</span>
                        <span class="meta-chip"><i class="bi bi-clock"></i> 11:00 AM</span>
                    </div>
                </div>
                <span class="badge-custom-emerald" style="font-size:0.72rem; padding:0.35em 0.85em;">Shortlisted</span>
            </div>

            {{-- Past 2 --}}
            <div class="interview-card" style="opacity:0.7;">
                <div class="company-avatar" style="background:#F3F4F6; color:#6B7280;">TH</div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem;">Frontend Developer</h6>
                        <span class="status-badge" style="background:#F3F4F6; color:#6B7280; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem;">Completed</span>
                    </div>
                    <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">TechHub</div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="meta-chip"><i class="bi bi-calendar3"></i> 02 Mar 2024</span>
                        <span class="meta-chip"><i class="bi bi-clock"></i> 09:30 AM</span>
                    </div>
                </div>
                <span class="badge-custom-rose" style="font-size:0.72rem; padding:0.35em 0.85em;">Rejected</span>
            </div>

        </div>
    </div>

</div>
@endsection