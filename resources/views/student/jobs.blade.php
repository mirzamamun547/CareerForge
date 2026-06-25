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

    {{-- Search & Filter Bar --}}
    <div class="card card-custom p-3 mb-4">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="search-wrapper flex-grow-1" style="min-width: 220px;">
                <i class="bi bi-search"></i>
                <input type="text" class="search-bar" placeholder="Search jobs, companies..." id="jobSearchInput">
            </div>
            <button class="filter-btn" id="filterToggleBtn">
                <i class="bi bi-sliders"></i> Filter
            </button>
        </div>

        {{-- Filter Chips --}}
        <div class="d-flex flex-wrap gap-2 mt-3" id="filterChips">
            <span class="filter-chip active" data-filter="all">All</span>
            <span class="filter-chip" data-filter="Full Time">Full Time</span>
            <span class="filter-chip" data-filter="Part Time">Part Time</span>
            <span class="filter-chip" data-filter="Remote">Remote</span>
            <span class="filter-chip" data-filter="Contract">Contract</span>
            <span class="filter-chip" data-filter="Internship">Internship</span>
        </div>
    </div>

    {{-- Results Count --}}
    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <span class="results-count" id="resultsCount"><strong>5</strong> jobs found</span>
        <div class="d-flex align-items-center gap-2">
            <span style="font-size:0.78rem; color:#9CA3AF;">Sort by:</span>
            <select class="form-select form-select-sm" style="font-size:0.78rem; border-radius:0.5rem; border-color:#E5E7EB; width:auto; padding: 0.25rem 1.75rem 0.25rem 0.75rem;">
                <option>Newest First</option>
                <option>Oldest First</option>
                <option>Salary: High to Low</option>
            </select>
        </div>
    </div>

    {{-- Job Cards --}}
    <div class="d-flex flex-column gap-3" id="jobList">

        {{-- Job 1 --}}
        <div class="job-card d-flex flex-column gap-0" data-type="Full Time" data-title="junior php developer" data-company="techsoft ltd">
            <div class="d-flex align-items-start gap-3">
                <div class="job-logo" style="background-color: #EEF2FF; color: #4F46E5;">TS</div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">Junior PHP Developer</h6>
                            <span class="text-secondary" style="font-size:0.78rem;">TechSoft Ltd</span>
                        </div>
                        <span class="badge-job-type badge-full-time">Full Time</span>
                    </div>
                    <hr class="section-divider mt-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> Dhaka, Bangladesh
                            </span>
                            <span class="salary-tag d-flex align-items-center gap-1">
                                <i class="bi bi-currency-dollar"></i> 25,000 – 35,000
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="posted-date"><i class="bi bi-clock me-1"></i>Posted 2 days ago</span>
                            <button class="job-apply-btn">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job 2 --}}
        <div class="job-card d-flex flex-column gap-0" data-type="Full Time" data-title="laravel developer" data-company="creative it">
            <div class="d-flex align-items-start gap-3">
                <div class="job-logo" style="background-color: #ECFDF5; color: #10B981;">CI</div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">Laravel Developer</h6>
                            <span class="text-secondary" style="font-size:0.78rem;">Creative IT, Dhaka</span>
                        </div>
                        <span class="badge-job-type badge-full-time">Full Time</span>
                    </div>
                    <hr class="section-divider mt-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> Dhaka, Bangladesh
                            </span>
                            <span class="salary-tag d-flex align-items-center gap-1">
                                <i class="bi bi-currency-dollar"></i> 40,000 – 60,000
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="posted-date"><i class="bi bi-clock me-1"></i>Posted 3 days ago</span>
                            <button class="job-apply-btn applied"><i class="bi bi-check-circle me-1"></i>Applied</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job 3 --}}
        <div class="job-card d-flex flex-column gap-0" data-type="Remote" data-title="web developer" data-company="brain station 23">
            <div class="d-flex align-items-start gap-3">
                <div class="job-logo" style="background-color: #FEF3C7; color: #D97706;">BS</div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">Web Developer</h6>
                            <span class="text-secondary" style="font-size:0.78rem;">Brain Station 23</span>
                        </div>
                        <span class="badge-job-type badge-remote">Remote</span>
                    </div>
                    <hr class="section-divider mt-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> Mirpur, Dhaka
                            </span>
                            <span class="salary-tag d-flex align-items-center gap-1">
                                <i class="bi bi-currency-dollar"></i> 30,000 – 45,000
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="posted-date"><i class="bi bi-clock me-1"></i>Posted 4 days ago</span>
                            <button class="job-apply-btn">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job 4 --}}
        <div class="job-card d-flex flex-column gap-0" data-type="Part Time" data-title="frontend developer" data-company="codeFlex">
            <div class="d-flex align-items-start gap-3">
                <div class="job-logo" style="background-color: #FFF1F2; color: #F43F5E;">CF</div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">Frontend Developer</h6>
                            <span class="text-secondary" style="font-size:0.78rem;">CodeFlex</span>
                        </div>
                        <span class="badge-job-type badge-part-time">Part Time</span>
                    </div>
                    <hr class="section-divider mt-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> Mirpur, Dhaka
                            </span>
                            <span class="salary-tag d-flex align-items-center gap-1">
                                <i class="bi bi-currency-dollar"></i> 15,000 – 20,000
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="posted-date"><i class="bi bi-clock me-1"></i>Posted 5 days ago</span>
                            <button class="job-apply-btn">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job 5 --}}
        <div class="job-card d-flex flex-column gap-0" data-type="Internship" data-title="backend developer intern" data-company="softcloud">
            <div class="d-flex align-items-start gap-3">
                <div class="job-logo" style="background-color: #F3F4F6; color: #6B7280;">SC</div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">Backend Developer Intern</h6>
                            <span class="text-secondary" style="font-size:0.78rem;">SoftCloud</span>
                        </div>
                        <span class="badge-job-type badge-internship">Internship</span>
                    </div>
                    <hr class="section-divider mt-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-3">
                            <span class="text-secondary d-flex align-items-center gap-1" style="font-size:0.78rem;">
                                <i class="bi bi-geo-alt" style="color:#9CA3AF;"></i> Chittagong
                            </span>
                            <span class="salary-tag d-flex align-items-center gap-1" style="color:#9CA3AF; font-weight:600;">
                                Stipend: 8,000
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="posted-date"><i class="bi bi-clock me-1"></i>Posted 1 week ago</span>
                            <button class="job-apply-btn">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Empty State (hidden by default) --}}
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
    const filterChips = document.querySelectorAll('.filter-chip');
    const jobCards   = document.querySelectorAll('#jobList .job-card');
    const resultsCount = document.getElementById('resultsCount');
    const emptyState   = document.getElementById('emptyState');
    let activeFilter = 'all';

    function filterJobs() {
        const q = searchInput.value.trim().toLowerCase();
        let count = 0;
        jobCards.forEach(card => {
            const title   = card.dataset.title   || '';
            const company = card.dataset.company || '';
            const type    = card.dataset.type    || '';
            const matchQ = !q || title.includes(q) || company.includes(q);
            const matchF = activeFilter === 'all' || type === activeFilter;
            if (matchQ && matchF) {
                card.style.display = '';
                count++;
            } else {
                card.style.display = 'none';
            }
        });
        resultsCount.innerHTML = `<strong>${count}</strong> job${count !== 1 ? 's' : ''} found`;
        emptyState.classList.toggle('d-none', count > 0);
    }

    searchInput.addEventListener('input', filterJobs);

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeFilter = chip.dataset.filter;
            filterJobs();
        });
    });

    // Apply Now button toggle
    document.querySelectorAll('.job-apply-btn:not(.applied)').forEach(btn => {
        btn.addEventListener('click', function () {
            this.innerHTML = '<i class="bi bi-check-circle me-1"></i>Applied';
            this.classList.add('applied');
        });
    });
</script>
@endpush