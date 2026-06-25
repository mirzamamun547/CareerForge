@extends('layouts.student')

@section('title', 'Dashboard')
@section('header_title', 'Welcome back, Rahim! 👋')
@section('header_subtitle', 'Here\'s your career overview.')

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
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">12</h2>
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
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">2</h2>
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
            <h2 class="fw-extrabold text-dark m-0" style="font-weight: 800; font-size: 1.85rem;">85%</h2>
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
            <h2 class="fw-extrabold m-0" style="font-weight: 800; font-size: 1.1rem; color: #D97706;">Under Review</h2>
            <span class="text-secondary" style="font-size: 0.7rem;">Pending feedback</span>
        </div>
    </div>
</section>

<!-- Main Content: Recent Activity & Quick Actions -->
<section class="row g-4">
    
    <!-- Recent Activity (2/3 width) -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                <h2 class="fw-bold text-dark m-0" style="font-size: 1rem;">Recent Activity</h2>
            </div>

            <div class="d-flex flex-column gap-3">
                <!-- Activity 1 -->
                <div class="d-flex align-items-start gap-3 p-3 border border-light-subtle rounded-3">
                    <div class="icon-shape flex-shrink-0" style="background-color: #EEF2FF; width: 2rem; height: 2rem;">
                        <i class="bi bi-send" style="font-size: 0.8rem; color: #4F46E5;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 text-dark fw-medium" style="font-size: 0.85rem;">You applied for <strong>Laravel Developer</strong></p>
                    </div>
                    <span class="text-secondary flex-shrink-0" style="font-size: 0.7rem;">2 days ago</span>
                </div>

                <!-- Activity 2 -->
                <div class="d-flex align-items-start gap-3 p-3 border border-light-subtle rounded-3">
                    <div class="icon-shape flex-shrink-0" style="background-color: #FEF3C7; width: 2rem; height: 2rem;">
                        <i class="bi bi-file-earmark-check" style="font-size: 0.8rem; color: #D97706;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 text-dark fw-medium" style="font-size: 0.85rem;">Your resume is <strong>under review</strong></p>
                    </div>
                    <span class="text-secondary flex-shrink-0" style="font-size: 0.7rem;">3 days ago</span>
                </div>

                <!-- Activity 3 -->
                <div class="d-flex align-items-start gap-3 p-3 border border-light-subtle rounded-3">
                    <div class="icon-shape flex-shrink-0" style="background-color: #ECFDF5; width: 2rem; height: 2rem;">
                        <i class="bi bi-calendar-check" style="font-size: 0.8rem; color: #10B981;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 text-dark fw-medium" style="font-size: 0.85rem;">Interview scheduled with <strong>Creative IT</strong></p>
                    </div>
                    <span class="text-secondary flex-shrink-0" style="font-size: 0.7rem;">5 days ago</span>
                </div>

                <!-- Activity 4 -->
                <div class="d-flex align-items-start gap-3 p-3 border border-light-subtle rounded-3">
                    <div class="icon-shape flex-shrink-0" style="background-color: #ECFDF5; width: 2rem; height: 2rem;">
                        <i class="bi bi-check-circle" style="font-size: 0.8rem; color: #10B981;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 text-dark fw-medium" style="font-size: 0.85rem;">Your application for <strong>Web Developer</strong> is shortlisted</p>
                    </div>
                    <span class="text-secondary flex-shrink-0" style="font-size: 0.7rem;">1 week ago</span>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="text-decoration-none fw-semibold" style="font-size: 0.85rem; color: #4F46E5;">View All</a>
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
                <a href="/student/resume" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-upload"></i>
                    Upload Resume
                </a>
                <a href="#jobs" class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-briefcase"></i>
                    Browse Jobs
                </a>
                <a href="#applications" class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="bi bi-folder2-open"></i>
                    View My Applications
                </a>
            </div>
        </div>
    </div>

</section>
@endsection
