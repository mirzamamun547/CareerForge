@extends('layouts.student')

@section('title', $job->title)
@section('header_title', $job->title)
@section('header_subtitle', 'Explore the full job details and apply directly.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4 p-lg-5">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <div class="badge-custom-indigo mb-2">Featured opportunity</div>
                        <h3 class="fw-bold text-dark mb-1">{{ $job->title }}</h3>
                        <p class="text-secondary mb-0">{{ $job->user->name ?? 'Company' }} • {{ $job->location }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge-custom-indigo">{{ $job->job_type }}</span>
                        <div class="mt-2 text-secondary small">{{ $job->level ?? 'Any Level' }}</div>
                    </div>
                </div>

                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Salary</div>
                            <div class="fw-bold text-dark">{{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }} BDT</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Category</div>
                            <div class="fw-bold text-dark">{{ $job->category }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Posted</div>
                            <div class="fw-bold text-dark">{{ $job->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold text-dark">Role overview</h6>
                    <p class="text-secondary mb-0" style="line-height: 1.8;">{{ $job->description }}</p>
                </div>

                <div class="mt-4 border-top border-light pt-4">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('student.jobs.apply.form', $job) }}" class="btn btn-primary-custom">Apply Now</a>
                        <a href="{{ route('student.jobs') }}" class="btn btn-outline-custom">Back to jobs</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3">Company snapshot</h6>
                @php $profile = $job->user->employerProfile; @endphp
                <div class="mb-3">
                    <div class="text-secondary small">Company</div>
                    <div class="fw-bold text-dark">{{ $profile->company_name ?? ($job->user->name ?? 'Company') }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Industry</div>
                    <div class="fw-bold text-dark">{{ $profile->industry ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Address</div>
                    <div class="fw-bold text-dark">{{ $profile->company_address ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Contact</div>
                    <div class="fw-bold text-dark">{{ $profile->contact_person ?? $job->user->name }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Website</div>
                    <div class="fw-bold text-dark">{{ $profile->website ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection