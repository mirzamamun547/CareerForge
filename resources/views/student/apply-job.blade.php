@extends('layouts.student')

@section('title', 'Apply for ' . $job->title)
@section('header_title', 'Apply for this role')
@section('header_subtitle', 'Complete your application in a few focused steps.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4 p-lg-5">
                <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                    <div>
                        <div class="badge-custom-indigo mb-2">Application Form</div>
                        <h4 class="fw-bold text-dark mb-1">Complete your application</h4>
                        <p class="text-secondary mb-0">Share a short note and submit your interest for {{ $job->title }}.</p>
                    </div>
                    <a href="{{ route('student.jobs.show', $job) }}" class="btn btn-outline-custom btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <form method="POST" action="{{ route('student.jobs.apply', $job) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Cover letter</label>
                        <textarea name="cover_letter" class="form-control form-control-custom" rows="6" placeholder="Tell the employer why you're a great fit for this opportunity."></textarea>
                        <div class="form-text text-secondary">A short message helps you stand out. Keep it concise and relevant.</div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Resume</label>
                            <input type="text" class="form-control form-control-custom" value="Resume uploaded from your profile" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Availability</label>
                            <select class="form-select form-control-custom">
                                <option>Immediate</option>
                                <option>1–2 weeks</option>
                                <option>1 month</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-send-fill me-2"></i>Submit Application
                        </button>
                        <a href="{{ route('student.jobs') }}" class="btn btn-secondary-custom">Save for later</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:3rem;height:3rem;background:#EEF2FF;color:#4F46E5;">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $job->title }}</h6>
                        <p class="text-secondary mb-0" style="font-size:0.8rem;">{{ $job->user->name ?? 'Company' }}</p>
                    </div>
                </div>
                <div class="border-top border-light pt-3 mt-2">
                    <div class="d-flex justify-content-between py-2"><span class="text-secondary">Location</span><strong class="text-dark">{{ $job->location }}</strong></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-secondary">Type</span><strong class="text-dark">{{ $job->job_type }}</strong></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-secondary">Salary</span><strong class="text-dark">{{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }}</strong></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-secondary">Posted</span><strong class="text-dark">{{ $job->created_at->format('d M Y') }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
