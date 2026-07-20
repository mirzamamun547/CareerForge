@extends('layouts.student')

@section('title', 'Saved Jobs')
@section('header_title', 'Saved Jobs')
@section('header_subtitle', 'Jobs you have bookmarked to review or apply later.')

@push('styles')
<style>
    .job-card {
        border: 1px solid #E5E7EB;
        border-radius: 1rem;
        background: #fff;
        padding: 1.25rem 1.35rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .job-card:hover {
        box-shadow: 0 8px 28px rgba(79, 70, 229, 0.11);
        transform: translateY(-2px);
        border-color: #C7D2FE;
    }
    .job-logo {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .badge-job-type {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.3em 0.75em;
        border-radius: 50rem;
    }
    .badge-full-time  { background-color: #EEF2FF; color: #4F46E5; }
    .badge-part-time  { background-color: #FEF3C7; color: #D97706; }
    .badge-remote     { background-color: #ECFDF5; color: #10B981; }
    .badge-contract   { background-color: #FFF1F2; color: #F43F5E; }
    .badge-internship { background-color: #F3F4F6; color: #6B7280; }
    .posted-date { font-size: 0.72rem; color: #9CA3AF; }
    .job-apply-btn {
        font-size: 0.8rem;
        padding: 0.45rem 1.1rem;
        border-radius: 0.6rem;
        font-weight: 600;
        background: #4F46E5;
        color: #fff;
        border: none;
        transition: background 0.2s;
        text-decoration: none;
        white-space: nowrap;
        display: inline-block;
    }
    .job-apply-btn:hover { background: #4338CA; color: #fff; }
    .job-apply-btn.applied {
        background: #ECFDF5;
        color: #10B981;
        border: 1.5px solid #A7F3D0;
    }
    .job-apply-btn.applied:hover { background: #D1FAE5; }
    .salary-tag {
        font-size: 0.75rem;
        color: #10B981;
        font-weight: 700;
    }
    .section-divider {
        border: none;
        border-top: 1px solid #F3F4F6;
        margin: 0.65rem 0;
    }
    .results-count { font-size: 0.82rem; color: #6B7280; }
    .pagination-wrapper nav svg {
        height: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <span class="results-count"><strong>{{ $bookmarks->total() }}</strong> saved job{{ $bookmarks->total() === 1 ? '' : 's' }}</span>
    </div>

    <div class="d-flex flex-column gap-3" id="savedJobList">
        @forelse($bookmarks as $bookmark)
            @php
                $job = $bookmark->jobListing;
            @endphp
            @continue(! $job)
            @php
                $applied = auth()->user()->jobApplications()->where('job_listing_id', $job->id)->exists();
            @endphp
            <div class="job-card d-flex flex-column gap-0">
                <div class="d-flex align-items-start gap-3">
                    <div class="job-logo" style="background-color: #EEF2FF; color: #4F46E5;">
                        {{ strtoupper(substr($job->user->name ?? 'C', 0, 2)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">{{ $job->title }}</h6>
                                <span class="text-secondary" style="font-size:0.78rem;">{{ $job->user->name ?? 'Company' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge-job-type
                                    @if($job->job_type === 'Full Time') badge-full-time
                                    @elseif($job->job_type === 'Part Time') badge-part-time
                                    @elseif($job->job_type === 'Remote') badge-remote
                                    @elseif($job->job_type === 'Contract') badge-contract
                                    @else badge-internship
                                    @endif">
                                    {{ $job->job_type }}
                                </span>
                                <form method="POST" action="{{ route('student.jobs.bookmark', $job) }}">
                                    @csrf
                                    <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="btn btn-sm btn-warning text-white rounded-pill" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" title="Remove from saved jobs">
                                        <i class="bi bi-bookmark-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr class="section-divider mt-2">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex flex-wrap gap-3">
                                <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                    <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i>
                                    @if($job->city && $job->country)
                                        {{ $job->city }}, {{ $job->country }}
                                    @else
                                        {{ $job->location }}
                                    @endif
                                </span>
                                <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;"><i class="bi bi-bar-chart" style="color:#9CA3AF;"></i> {{ $job->level ?? 'Any Level' }}</span>
                                <span class="salary-tag d-flex align-items-center gap-1"><i class="bi bi-currency-dollar"></i> {{ number_format($job->min_salary) }} – {{ number_format($job->max_salary) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="posted-date"><i class="bi bi-bookmark-check me-1"></i>Saved {{ $bookmark->created_at->diffForHumans() }}</span>
                                <a href="{{ route('student.jobs.show', $job) }}" class="btn btn-outline-custom btn-sm">View Details</a>
                                @if($applied)
                                    <a href="{{ route('student.applications') }}" class="job-apply-btn applied">
                                        <i class="bi bi-check-circle me-1"></i>Applied
                                    </a>
                                @else
                                    <a href="{{ route('student.jobs.apply.form', $job) }}" class="job-apply-btn">
                                        Apply Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 card card-custom">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:4rem;height:4rem;background:#EEF2FF;">
                    <i class="bi bi-bookmark-star" style="font-size:1.5rem;color:#4F46E5;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">No saved jobs yet</h6>
                <p class="text-secondary mb-3" style="font-size:0.82rem;">Bookmark a job from the listings to find it here later.</p>
                <a href="{{ route('student.jobs') }}" class="btn btn-primary-custom mx-auto" style="width:fit-content;">Browse Jobs</a>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4 pagination-wrapper">
        {{ $bookmarks->links() }}
    </div>
</div>
@endsection