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
        cursor: pointer;
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
    .filter-btn {
        border: 1.5px solid #E5E7EB;
        background: #fff;
        border-radius: 0.75rem;
        padding: 0.6rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4B5563;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .filter-btn:hover { border-color: #4F46E5; color: #4F46E5; background: #EEF2FF; }
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
        white-space: nowrap;
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
    .filter-chip {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3em 0.85em;
        border-radius: 50rem;
        border: 1.5px solid #E5E7EB;
        background: #fff;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.18s;
    }
    .filter-chip.active, .filter-chip:hover {
        border-color: #4F46E5;
        background: #EEF2FF;
        color: #4F46E5;
    }
    .results-count { font-size: 0.82rem; color: #6B7280; }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-3 mb-4">
        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" class="search-bar" placeholder="Search jobs, companies..." id="jobSearchInput">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <select class="form-select form-control-custom" id="jobTypeFilter">
                    <option value="">All Job Types</option>
                    <option>Full Time</option>
                    <option>Part Time</option>
                    <option>Remote</option>
                    <option>Contract</option>
                    <option>Internship</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <select class="form-select form-control-custom" id="levelFilter">
                    <option value="">All Levels</option>
                    <option>Entry Level</option>
                    <option>Mid Level</option>
                    <option>Senior Level</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <select class="form-select form-control-custom" id="locationFilter">
                    <option value="">All Locations</option>
                    @foreach($jobs->pluck('location')->unique() as $location)
                        <option>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <select class="form-select form-control-custom" id="salaryFilter">
                    <option value="">Any Salary</option>
                    <option value="30000">Above 30k</option>
                    <option value="50000">Above 50k</option>
                    <option value="80000">Above 80k</option>
                </select>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <span class="results-count" id="resultsCount"><strong>{{ $jobs->count() }}</strong> jobs found</span>
    </div>

    <div class="d-flex flex-column gap-3" id="jobList">
        @forelse($jobs as $job)
            @php
                $applied = auth()->user()->jobApplications()->where('job_listing_id', $job->id)->exists();
                $bookmarked = $bookmarkedIds->contains($job->id);
            @endphp
            <div class="job-card d-flex flex-column gap-0"
                 data-title="{{ strtolower($job->title) }}"
                 data-company="{{ strtolower($job->user->name ?? 'company') }}"
                 data-type="{{ $job->job_type }}"
                 data-level="{{ $job->level ?? '' }}"
                 data-location="{{ strtolower($job->location) }}"
                 data-salary="{{ $job->min_salary }}">
                <div class="d-flex align-items-start gap-3">
                    <div class="job-logo" style="background-color: #EEF2FF; color: #4F46E5;">{{ strtoupper(substr($job->user->name ?? 'C', 0, 2)) }}</div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">{{ $job->title }}</h6>
                                <span class="text-secondary" style="font-size:0.78rem;">{{ $job->user->name ?? 'Company' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge-job-type {{ $job->job_type === 'Full Time' ? 'badge-full-time' : ($job->job_type === 'Part Time' ? 'badge-part-time' : ($job->job_type === 'Remote' ? 'badge-remote' : 'badge-contract')) }}">{{ $job->job_type }}</span>
                                <form method="POST" action="{{ route('student.jobs.bookmark', $job) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $bookmarked ? 'btn-warning' : 'btn-outline-secondary' }} rounded-pill">
                                        <i class="bi {{ $bookmarked ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr class="section-divider mt-2">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex flex-wrap gap-3">
                                <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;"><i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> {{ $job->location }}</span>
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
            <div class="text-center py-5">
                <p class="text-secondary mb-0">No active jobs right now.</p>
            </div>
        @endforelse
    </div>

    <div id="emptyState" class="text-center py-5 d-none">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:4rem;height:4rem;background:#EEF2FF;">
            <i class="bi bi-briefcase-fill" style="font-size:1.5rem;color:#4F46E5;"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">No jobs found</h6>
        <p class="text-secondary mb-0" style="font-size:0.82rem;">Try adjusting your search or filter criteria.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('jobSearchInput');
    const jobTypeFilter = document.getElementById('jobTypeFilter');
    const levelFilter = document.getElementById('levelFilter');
    const locationFilter = document.getElementById('locationFilter');
    const salaryFilter = document.getElementById('salaryFilter');
    const jobCards = document.querySelectorAll('#jobList .job-card');
    const resultsCount = document.getElementById('resultsCount');
    const emptyState = document.getElementById('emptyState');

    function filterJobs() {
        const q = searchInput.value.trim().toLowerCase();
        const type = jobTypeFilter.value;
        const level = levelFilter.value;
        const location = locationFilter.value.trim().toLowerCase();
        const salary = parseInt(salaryFilter.value, 10) || 0;
        let count = 0;

        jobCards.forEach(card => {
            const title = card.dataset.title || '';
            const company = card.dataset.company || '';
            const cardType = card.dataset.type || '';
            const cardLevel = (card.dataset.level || '').toLowerCase();
            const cardLocation = (card.dataset.location || '').toLowerCase();
            const cardSalary = parseInt(card.dataset.salary || '0', 10);
            const matchQ = !q || title.includes(q) || company.includes(q);
            const matchType = !type || cardType === type;
            const matchLevel = !level || cardLevel === level.toLowerCase();
            const matchLocation = !location || cardLocation.includes(location);
            const matchSalary = !salary || cardSalary >= salary;

            const visible = matchQ && matchType && matchLevel && matchLocation && matchSalary;
            card.style.display = visible ? '' : 'none';
            if (visible) count++;
        });

        resultsCount.innerHTML = `<strong>${count}</strong> job${count !== 1 ? 's' : ''} found`;
        emptyState.classList.toggle('d-none', count > 0);
    }

    [searchInput, jobTypeFilter, levelFilter, locationFilter, salaryFilter].forEach(el => {
        el.addEventListener('input', filterJobs);
        el.addEventListener('change', filterJobs);
    });
</script>
@endpush