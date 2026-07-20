@extends('layouts.student')

@section('title', 'Browse Jobs')
@section('header_title', 'Browse Jobs')
@section('header_subtitle', 'Find your next opportunity.')

@section('header_actions')
<div class="d-flex align-items-center gap-2">
    <a href="/student/applications" class="btn btn-outline-custom d-flex align-items-center gap-2" style="font-size:0.85rem; padding:0.55rem 1.1rem;">
        <i class="bi bi-folder2-open"></i> My Applications
    </a>
</div>
@endsection

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
    .search-bar {
        border: 1.5px solid #E5E7EB;
        border-radius: 0.75rem;
        background: #F9FAFB;
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        font-size: 0.88rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-bar:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79,70,229,0.09);
        background: #fff;
    }
    .search-wrapper { position: relative; }
    .search-wrapper .bi-search {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 0.85rem;
    }
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
    <!-- Filter form -->
    <form action="{{ route('student.jobs') }}" method="GET">
        <div class="card card-custom p-3 mb-4">
            <div class="row g-3">
                <div class="col-12 col-lg-3">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" class="search-bar" placeholder="Search jobs, company, skills...">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <select class="form-select form-control-custom" name="job_type">
                        <option value="">All Job Types</option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <select class="form-select form-control-custom" name="level">
                        <option value="">All Levels</option>
                        @foreach($levels as $lvl)
                            <option value="{{ $lvl }}" {{ request('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <select class="form-select form-control-custom" name="location">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <select class="form-select form-control-custom" name="salary">
                        <option value="">Any Salary</option>
                        <option value="30000" {{ request('salary') == '30000' ? 'selected' : '' }}>Above 30k</option>
                        <option value="50000" {{ request('salary') == '50000' ? 'selected' : '' }}>Above 50k</option>
                        <option value="80000" {{ request('salary') == '80000' ? 'selected' : '' }}>Above 80k</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-1">
                    <select class="form-select form-control-custom" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="match" {{ request('sort') == 'match' ? 'selected' : '' }}>Best Match</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3 pt-2 border-top border-light">
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="remoteSwitch" name="remote" value="1" {{ request('remote') ? 'checked' : '' }}>
                        <label class="form-check-label text-dark fw-semibold" for="remoteSwitch" style="font-size: 0.85rem;">Remote Only</label>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    @if(request()->anyFilled(['q', 'job_type', 'level', 'location', 'salary', 'remote', 'sort']))
                        <a href="{{ route('student.jobs') }}" class="btn btn-secondary-custom btn-sm py-2 px-3 d-flex align-items-center gap-1">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary-custom btn-sm py-2 px-4">
                        <i class="bi bi-funnel-fill me-1"></i> Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <span class="results-count">Showing <strong>{{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }}</strong> of <strong>{{ $jobs->total() }}</strong> jobs found</span>
    </div>

    <div class="d-flex flex-column gap-3" id="jobList">
        @forelse($jobs as $job)
            @php
                $applied = auth()->user()->jobApplications()->where('job_listing_id', $job->id)->exists();
                $bookmarked = $bookmarkedIds->contains($job->id);
            @endphp
            <div class="job-card d-flex flex-column gap-0">
                <div class="d-flex align-items-start gap-3">
                    <div class="job-logo" style="background-color: #EEF2FF; color: #4F46E5;">
                        {{ strtoupper(substr($job->user->name ?? 'C', 0, 2)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">{{ $job->title }}</h6>
                                    @if(!is_null($job->match_percentage))
                                        <span class="badge rounded-pill" style="font-size:0.68rem; font-weight:700; padding:0.3em 0.65em;
                                            background-color: {{ $job->match_percentage >= 70 ? '#ECFDF5' : ($job->match_percentage >= 40 ? '#FEF3C7' : '#FFF1F2') }};
                                            color: {{ $job->match_percentage >= 70 ? '#10B981' : ($job->match_percentage >= 40 ? '#D97706' : '#F43F5E') }};">
                                            <i class="bi bi-stars"></i> {{ $job->match_percentage }}% Match
                                        </span>
                                    @endif
                                </div>
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
                                    <button type="submit" class="btn btn-sm {{ $bookmarked ? 'btn-warning text-white' : 'btn-outline-secondary' }} rounded-pill" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                        <i class="bi {{ $bookmarked ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
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
                                <span class="posted-date"><i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}</span>
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
                    <i class="bi bi-briefcase-fill" style="font-size:1.5rem;color:#4F46E5;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">No jobs found</h6>
                <p class="text-secondary mb-0" style="font-size:0.82rem;">Try adjusting your search or filter criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center mt-4 pagination-wrapper">
        {{ $jobs->links() }}
    </div>
</div>
@endsection