@extends('layouts.student')

@section('title', 'Dashboard')
@section('header_title')Welcome back, {{ auth()->user()->name }}! 👋@endsection
@section('header_subtitle')Here's your career overview.@endsection

@section('content')
<!-- Metrics Summary Cards -->
<section class="row g-4">
    <!-- Card 1: Applications -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Applications</span>
                <div class="icon-shape" style="color: #4F46E5 !important; background-color: #EEF2FF !important;">
                    <i class="bi bi-send fs-5" style="color: #4F46E5;"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalApplications }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Total Applied</span>
        </div>
    </div>

    <!-- Card 2: Interviews -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Interviews</span>
                <div class="icon-shape bg-success bg-opacity-10">
                    <i class="bi bi-camera-video fs-5 text-success"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $totalInterviews }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Upcoming</span>
        </div>
    </div>

    <!-- Card 3: Profile Completion -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Profile Completion</span>
                <div class="icon-shape bg-warning bg-opacity-10">
                    <i class="bi bi-person-check fs-5 text-warning"></i>
                </div>
            </div>
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">{{ $profileCompletion }}%</h2>
            <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                <div class="progress-bar bg-warning" style="width: {{ $profileCompletion }}%;"></div>
            </div>
            <span class="text-secondary" style="font-size: 0.7rem;">Completed</span>
        </div>
    </div>

    <!-- Card 4: Resume Status -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-uppercase text-secondary fw-semibold tracking-wider" style="font-size: 0.65rem;">Resume Status</span>
                <div class="icon-shape bg-danger bg-opacity-10">
                    <i class="bi bi-file-earmark-text fs-5 text-danger"></i>
                </div>
            </div>
            <h2 class="fw-extrabold m-0" style="font-weight: 800; font-size: 1.1rem; color: {{ $resumeStatusColor }};">{{ $resumeStatus }}</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">
                @if($resumeStatus === 'Not Uploaded')
                    Upload to get started
                @elseif($resumeStatus === 'Under Review')
                    Pending admin feedback
                @elseif($resumeStatus === 'AI Reviewed')
                    AI analysis done
                @else
                    Admin feedback available
                @endif
            </span>
        </div>
    </div>
</section>

<!-- Main Content: Recent Activity & Quick Actions -->
<section class="row g-4">

    <!-- Recent Applications (2/3 width) -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Recent Applications</h2>
                <a href="{{ route('student.applications') }}" class="text-decoration-none fw-semibold" style="font-size: 0.75rem; color: #4F46E5;">View All</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($recentApplications as $application)
                    @php
                        $status = $application->status ?? 'Pending';
                        $statusColor = match(strtolower($status)) {
                            'accepted', 'shortlisted' => '#10B981',
                            'rejected'                => '#EF4444',
                            'interview'               => '#4F46E5',
                            default                   => '#D97706',
                        };
                        $statusBg = match(strtolower($status)) {
                            'accepted', 'shortlisted' => '#ECFDF5',
                            'rejected'                => '#FEF2F2',
                            'interview'               => '#EEF2FF',
                            default                   => '#FEF3C7',
                        };
                        $icon = match(strtolower($status)) {
                            'accepted', 'shortlisted' => 'bi-check-circle',
                            'rejected'                => 'bi-x-circle',
                            'interview'               => 'bi-camera-video',
                            default                   => 'bi-send',
                        };
                    @endphp
                    <div class="d-flex align-items-start gap-3 p-3 border border-light-subtle rounded-3">
                        <div class="icon-shape flex-shrink-0" style="background-color: {{ $statusBg }}; width: 2rem; height: 2rem;">
                            <i class="bi {{ $icon }}" style="font-size: 0.8rem; color: {{ $statusColor }};"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 text-dark fw-medium" style="font-size: 0.85rem;">
                                Applied for <strong>{{ $application->jobListing->title ?? 'Unknown Job' }}</strong>
                            </p>
                            <span class="badge rounded-pill px-2 mt-1" style="font-size: 0.65rem; background-color: {{ $statusBg }}; color: {{ $statusColor }};">
                                {{ $status }}
                            </span>
                        </div>
                        <span class="text-secondary flex-shrink-0" style="font-size: 0.7rem;">{{ $application->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-4 text-secondary">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        <p class="mb-2" style="font-size: 0.85rem;">No applications yet.</p>
                        <a href="{{ route('student.jobs') }}" class="btn btn-sm btn-primary-custom">Browse Jobs</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions (1/3 width) -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Quick Actions</h2>
            </div>

            <div class="d-flex flex-column gap-3">
                <a href="{{ route('student.resume') }}" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-upload"></i>
                    {{ auth()->user()->resume ? 'Update Resume' : 'Upload Resume' }}
                </a>
                <a href="{{ route('student.jobs') }}" class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-briefcase"></i>
                    Browse Jobs
                </a>
                <a href="{{ route('student.applications') }}" class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-folder2-open"></i>
                    View My Applications
                </a>
                <a href="{{ route('student.profile') }}" class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-person-circle"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Profile Summary Card -->
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mt-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.1rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ auth()->user()->name }}</p>
                    <p class="text-secondary mb-0" style="font-size: 0.75rem;">{{ auth()->user()->email }}</p>
                    @if($profile?->university)
                        <p class="text-secondary mb-0" style="font-size: 0.72rem;">{{ $profile->university }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Recommended Jobs Section -->
<section class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Recommended Opportunities</h2>
                <a href="{{ route('student.jobs') }}" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.75rem; color: #4F46E5 !important;">Explore All</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($recommendedJobs as $job)
                    <div class="p-3 border border-light-subtle rounded-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 text-white fw-bold d-flex align-items-center justify-content-center" style="width: 2.75rem; height: 2.75rem; background-color: #EEF2FF; color: #4F46E5 !important;">
                                {{ strtoupper(substr($job->user->name ?? 'C', 0, 2)) }}
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">{{ $job->title }}</h6>
                                <span class="text-secondary small">{{ $job->user->employerProfile->company_name ?? $job->user->name ?? 'Company' }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3 justify-content-between justify-content-md-end">
                            <span class="text-secondary small d-flex align-items-center gap-1">
                                <i class="bi bi-geo-alt"></i>
                                {{ $job->location }}
                            </span>
                            <span class="badge bg-light text-secondary border border-light-subtle px-2 py-1" style="border-radius: 50rem; font-size: 0.7rem;">
                                {{ $job->job_type }}
                            </span>
                            <a href="{{ route('student.jobs.show', $job) }}" class="btn btn-sm btn-outline-custom">View Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary text-center py-3 mb-0">No active job listings at this time.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
