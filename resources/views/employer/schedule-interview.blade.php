@extends('layouts.employer')

@section('title', 'Schedule Interview')
@section('header_title', 'Schedule a New Interview')
@section('header_subtitle', 'Set up an interview with a selected applicant.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        <!-- Left Column: Schedule Form -->
        <div class="col-12 col-lg-7">
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark mb-4" style="font-size: 1.1rem;">Schedule a New Interview</h5>

                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Select Applicant</label>
                            <select class="form-select form-control-custom">
                                <option>Select Applicant</option>
                                <option>Raihan Uddin</option>
                                <option>Tasnimul Islam</option>
                                <option>Sadia Akter</option>
                                <option>Hasibul Hasan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Position</label>
                            <select class="form-select form-control-custom">
                                <option>Select Job</option>
                                <option>Backend Developer</option>
                                <option>Laravel Developer</option>
                                <option>UI/UX Designer</option>
                                <option>PHP Developer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Date</label>
                            <input type="date" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Time</label>
                            <input type="time" class="form-control form-control-custom">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Type</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="interviewType" id="typeOnline" checked style="border-color: #4F46E5;">
                                    <label class="form-check-label fw-medium text-dark" for="typeOnline" style="font-size: 0.85rem;">Online</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="interviewType" id="typeOnsite" style="border-color: #4F46E5;">
                                    <label class="form-check-label fw-medium text-dark" for="typeOnsite" style="font-size: 0.85rem;">On-site</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Location / Meeting Link</label>
                            <input type="text" class="form-control form-control-custom" placeholder="e.g. Zoom link or Office Address">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Note for Applicant</label>
                            <textarea class="form-control form-control-custom" rows="3" placeholder="Any special instructions for the interview..."></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                            <i class="bi bi-calendar-check"></i>
                            Schedule Interview
                        </button>
                        <a href="/employer/interview-schedule" class="btn btn-secondary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Applicant Info Preview -->
        <div class="col-12 col-lg-5">
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark mb-4" style="font-size: 1.1rem;">Applicant Info</h5>

                <div class="text-center mb-4">
                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto" style="width: 70px; height: 70px; font-size: 1.3rem;">
                        RU
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Name</span>
                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;">Raihan Uddin</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Applied For</span>
                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;">Backend Developer</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Email</span>
                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;">raihan@example.com</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Phone</span>
                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;">+880 1712-345678</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
