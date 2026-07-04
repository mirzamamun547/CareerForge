@extends('layouts.student')

@section('title', 'Application Submitted')
@section('header_title', 'Application submitted')
@section('header_subtitle', 'Your application is on its way to the hiring team.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4 p-lg-5 text-center">
        <div class="mx-auto mb-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 5rem; height: 5rem; background: #ECFDF5; color: #10B981; font-size: 1.6rem;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="fw-bold text-dark mb-2">You’re all set!</h3>
        <p class="text-secondary mb-4">Your application for <strong>{{ $job->title }}</strong> was submitted successfully. The employer can now review your profile and cover note.</p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('student.applications') }}" class="btn btn-primary-custom">View my applications</a>
            <a href="{{ route('student.jobs') }}" class="btn btn-outline-custom">Explore more roles</a>
        </div>
    </div>
</div>
@endsection
