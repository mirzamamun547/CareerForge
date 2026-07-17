@extends('layouts.employer')

@section('title', 'Dashboard')
@section('header_title', 'Welcome back, CareerForge')
@section('header_subtitle', 'Here\'s what\'s happening with your jobs today.')

@section('content')
<!-- Metrics Summary Cards -->
<section class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Active Jobs</span>
                <div class="icon-shape bg-primary bg-opacity-10 text-primary" style="color: #4F46E5 !important; background-color: #EEF2FF !important;">
                    <i class="bi bi-briefcase fs-5"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalActiveJobs }}</h2>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Total Applicants</span>
                <div class="icon-shape bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people fs-5"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalApplicants }}</h2>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Interviews</span>
                <div class="icon-shape bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-calendar4-event fs-5"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">8</h2>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Hired</span>
                <div class="icon-shape bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-person-check fs-5"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">3</h2>
        </div>
    </div>
</section>

<!-- Main Content Splits: Recent Applicants & Upcoming Interviews -->
<section class="row g-4 items-start">
    
    <!-- Recent Applicants (2/3 width on desktop) -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Recent Applicants</h2>
                <a href="#applicants" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.75rem; color: #4F46E5 !important;">View All</a>
            </div>

            <!-- Applicants List -->
            <div class="d-flex flex-column gap-3">
                <!-- Applicant 1 -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 border border-light-subtle rounded-3 bg-light bg-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 2.5rem; height: 2.5rem; color: #4F46E5 !important;">RU</div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">Raihan Uddin</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Backend Developer</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center justify-content-sm-end gap-4">
                        <div class="text-secondary font-medium" style="font-size: 0.75rem;">16 May 2024</div>
                        <span class="badge-custom-indigo">Under Review</span>
                    </div>
                </div>

                <!-- Applicant 2 -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 border border-light-subtle rounded-3 bg-light bg-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success fw-bold d-flex align-items-center justify-content-center" style="width: 2.5rem; height: 2.5rem;">TI</div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">Tasnima Islam</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">UI/UX Designer</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center justify-content-sm-end gap-4">
                        <div class="text-secondary font-medium" style="font-size: 0.75rem;">15 May 2024</div>
                        <span class="badge-custom-emerald">Shortlisted</span>
                    </div>
                </div>

                <!-- Applicant 3 -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 border border-light-subtle rounded-3 bg-light bg-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center justify-content-center" style="width: 2.5rem; height: 2.5rem;">SA</div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">Sadia Akter</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Laravel Developer</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center justify-content-sm-end gap-4">
                        <div class="text-secondary font-medium" style="font-size: 0.75rem;">14 May 2024</div>
                        <span class="badge-custom-rose">Interview</span>
                    </div>
                </div>

                <!-- Applicant 4 -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 border border-light-subtle rounded-3 bg-light bg-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning fw-bold d-flex align-items-center justify-content-center" style="width: 2.5rem; height: 2.5rem;">HH</div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">Hasibul Hasan</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">PHP Developer</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center justify-content-sm-end gap-4">
                        <div class="text-secondary font-medium" style="font-size: 0.75rem;">10 May 2024</div>
                        <span class="badge-custom-amber">Applied</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Interviews (1/3 width on desktop) -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Upcoming Interviews</h2>
                <a href="#schedule" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.75rem; color: #4F46E5 !important;">View Schedule</a>
            </div>

            <div class="d-flex flex-column gap-3">
                <!-- Interview 1 -->
                <div class="p-3 border border-light rounded-3 bg-light bg-opacity-30 d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">Raihan Uddin</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle" style="font-size: 0.65rem; color: #4F46E5 !important; border-color: #C7D2FE !important;">Online</span>
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem;">Backend Developer</div>
                    <div class="d-flex align-items-center gap-2 text-secondary font-medium mt-1" style="font-size: 0.7rem;">
                        <i class="bi bi-clock"></i>
                        20 May 2024 at 10:00 AM
                    </div>
                </div>

                <!-- Interview 2 -->
                <div class="p-3 border border-light rounded-3 bg-light bg-opacity-30 d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">Tasnima Islam</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle" style="font-size: 0.65rem; color: #4F46E5 !important; border-color: #C7D2FE !important;">Online</span>
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem;">UI/UX Designer</div>
                    <div class="d-flex align-items-center gap-2 text-secondary font-medium mt-1" style="font-size: 0.7rem;">
                        <i class="bi bi-clock"></i>
                        21 May 2024 at 02:00 PM
                    </div>
                </div>

                <!-- Interview 3 -->
                <div class="p-3 border border-light rounded-3 bg-light bg-opacity-30 d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">Sadia Akter</span>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle" style="font-size: 0.65rem;">On-site</span>
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem;">Laravel Developer</div>
                    <div class="d-flex align-items-center gap-2 text-secondary font-medium mt-1" style="font-size: 0.7rem;">
                        <i class="bi bi-clock"></i>
                        22 May 2024 at 11:00 AM
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Recent Job Openings -->
<section class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">My Recent Job Listings</h2>
                <a href="{{ route('employer.manage-jobs') }}" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.75rem; color: #4F46E5 !important;">Manage All</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead>
                        <tr class="text-secondary" style="border-bottom: 2px solid #F3F4F6;">
                            <th class="pb-3 fw-semibold">Job Title</th>
                            <th class="pb-3 fw-semibold">Location</th>
                            <th class="pb-3 fw-semibold">Applicants</th>
                            <th class="pb-3 fw-semibold">Status</th>
                            <th class="pb-3 fw-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="py-3 fw-bold text-dark">{{ $job->title }}</td>
                                <td class="py-3 text-secondary">
                                    📍 {{ $job->city ?? ($job->location ?: 'N/A') }}
                                </td>
                                <td class="py-3 text-secondary">
                                    {{ $job->applications()->count() }} applied
                                </td>
                                <td class="py-3">
                                    <span class="badge {{ $job->status === 'Active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} px-2.5 py-1.5" style="border-radius: 50rem; font-size: 0.75rem;">
                                        {{ $job->status }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a href="/employer/manage-jobs" class="btn btn-sm btn-outline-custom">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">No job postings yet. <a href="{{ route('employer.jobs') }}" class="text-primary text-decoration-none">Post a Job</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
