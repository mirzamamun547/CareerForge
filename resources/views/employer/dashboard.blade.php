@extends('layouts.employer')

@section('title', 'Dashboard')
@section('header_title')Welcome back, {{ auth()->user()->employerProfile->company_name ?? auth()->user()->name }}! 👋@endsection
@section('header_subtitle')Here's what's happening with your jobs today.@endsection

@section('content')
<!-- Metrics Summary Cards -->
<section class="row g-4">
    <!-- Card 1: Active Jobs -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Active Jobs</span>
                <div class="icon-shape bg-primary bg-opacity-10" style="color: #4F46E5 !important; background-color: #EEF2FF !important;">
                    <i class="bi bi-briefcase fs-5"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalActiveJobs }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Open positions</span>
        </div>
    </div>

    <!-- Card 2: Total Applicants -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Applicants</span>
                <div class="icon-shape bg-success bg-opacity-10">
                    <i class="bi bi-people fs-5 text-success"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalApplicants }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Across all jobs</span>
        </div>
    </div>

    <!-- Card 3: Upcoming Interviews -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Interviews</span>
                <div class="icon-shape bg-warning bg-opacity-10">
                    <i class="bi bi-calendar4-event fs-5 text-warning"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalInterviews }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Upcoming scheduled</span>
        </div>
    </div>

    <!-- Card 4: Hired (Accepted applications) -->
    <div class="col-12 col-sm-6 col-xl-3">
        @php
            $hired = \App\Models\JobApplication::whereIn('job_listing_id', auth()->user()->jobListings()->pluck('id'))
                ->where('status', 'Accepted')->count();
        @endphp
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Hired</span>
                <div class="icon-shape bg-danger bg-opacity-10">
                    <i class="bi bi-person-check fs-5 text-danger"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $hired }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Accepted candidates</span>
        </div>
    </div>
</section>

<!-- Recent Applicants & Upcoming Interviews -->
<section class="row g-4 items-start">

    <!-- Recent Applicants (2/3 width) -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Recent Applicants</h2>
                <a href="{{ route('employer.applicants') }}" class="text-decoration-none fw-semibold" style="font-size: 0.75rem; color: #4F46E5;">View All</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($recentApplicants as $application)
                    @php
                        $status = $application->status ?? 'Pending';
                        $badgeClass = match(strtolower($status)) {
                            'accepted', 'shortlisted' => 'bg-success bg-opacity-10 text-success',
                            'rejected'                => 'bg-danger bg-opacity-10 text-danger',
                            'interview'               => 'bg-primary bg-opacity-10 text-primary',
                            default                   => 'bg-warning bg-opacity-10 text-warning',
                        };
                        $initials = strtoupper(substr($application->student->name ?? '?', 0, 2));
                        $avatarColors = ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'];
                        $avatarColor = $avatarColors[$application->id % count($avatarColors)];
                    @endphp
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 border border-light-subtle rounded-3 gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle {{ $avatarColor }} bg-opacity-10 fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 2.5rem; height: 2.5rem; font-size: 0.8rem;">
                                {{ $initials }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $application->student->name ?? 'Unknown' }}</div>
                                <div class="text-secondary" style="font-size: 0.75rem;">{{ $application->jobListing->title ?? 'Unknown Job' }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center justify-content-sm-end gap-4">
                            <div class="text-secondary" style="font-size: 0.75rem;">{{ $application->created_at->format('d M Y') }}</div>
                            <span class="badge {{ $badgeClass }} px-2 py-1 rounded-pill" style="font-size: 0.7rem;">{{ $status }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-secondary">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        <p class="mb-2" style="font-size: 0.85rem;">No applicants yet.</p>
                        <a href="{{ route('employer.jobs') }}" class="btn btn-sm btn-primary-custom">Post a Job</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Upcoming Interviews (1/3 width) -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Upcoming Interviews</h2>
                <a href="{{ route('employer.interview-schedule') }}" class="text-decoration-none fw-semibold" style="font-size: 0.75rem; color: #4F46E5;">View Schedule</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($upcomingInterviews as $interview)
                    <div class="p-3 border border-light rounded-3 bg-light bg-opacity-30 d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $interview->student->name ?? 'Unknown' }}</span>
                            <span class="badge bg-primary bg-opacity-10 border border-primary-subtle" style="font-size: 0.65rem; color: #4F46E5 !important;">
                                {{ $interview->mode ?? 'Online' }}
                            </span>
                        </div>
                        <div class="text-secondary" style="font-size: 0.75rem;">{{ $interview->jobApplication->jobListing->title ?? '' }}</div>
                        <div class="d-flex align-items-center gap-2 text-secondary mt-1" style="font-size: 0.7rem;">
                            <i class="bi bi-clock"></i>
                            {{ $interview->scheduled_at->format('d M Y \a\t h:i A') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3 text-secondary">
                        <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
                        <p class="mb-2" style="font-size: 0.82rem;">No upcoming interviews.</p>
                        <a href="{{ route('employer.schedule-interview') }}" class="btn btn-sm btn-outline-custom">Schedule One</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</section>

<!-- Recent Job Listings -->
<section class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">My Recent Job Listings</h2>
                <a href="{{ route('employer.manage-jobs') }}" class="text-decoration-none fw-semibold" style="font-size: 0.75rem; color: #4F46E5;">Manage All</a>
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
                                    <i class="bi bi-geo-alt me-1"></i>{{ $job->location ?: 'N/A' }}
                                </td>
                                <td class="py-3 text-secondary">
                                    {{ $job->applications()->count() }} applied
                                </td>
                                <td class="py-3">
                                    <span class="badge px-2 py-1 rounded-pill" style="font-size: 0.72rem; {{ $job->status === 'Active' ? 'background:#ECFDF5;color:#065F46;' : 'background:#FEF2F2;color:#991B1B;' }}">
                                        {{ $job->status }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('employer.manage-jobs') }}" class="btn btn-sm btn-outline-custom">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">
                                    No job postings yet.
                                    <a href="{{ route('employer.jobs') }}" class="text-primary text-decoration-none fw-semibold">Post a Job</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
