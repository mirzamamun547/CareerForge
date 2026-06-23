@extends('layouts.employer')

@section('title', 'Post a Job')
@section('header_title', 'Post a New Job')
@section('header_subtitle', 'Create a new career listing for prospective applicants.')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card card-custom p-4">
                
                <!-- Card Header with Edit Option on the Top Right -->
                <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                    <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">Job Details Form</h5>
                    <a href="/employer/manage-jobs" class="btn btn-warning-custom d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
                        <i class="bi bi-pencil-square"></i>
                        Edit / Manage Jobs
                    </a>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Title</label>
                        <input type="text" class="form-control form-control-custom" placeholder="e.g. Laravel Developer" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Category</label>
                        <select class="form-select form-control-custom">
                            <option>Development</option>
                            <option>Design</option>
                            <option>Marketing</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Type</label>
                        <select class="form-select form-control-custom">
                            <option>Full Time</option>
                            <option>Part Time</option>
                            <option>Internship</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Location</label>
                        <input type="text" class="form-control form-control-custom" placeholder="Dhaka, Bangladesh" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Salary Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" class="form-control form-control-custom" placeholder="Min (BDT)" required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control form-control-custom" placeholder="Max (BDT)" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Description</label>
                        <textarea class="form-control form-control-custom" rows="5" placeholder="Briefly describe the requirements, qualifications, and duties..." required></textarea>
                    </div>

                    <!-- Action buttons at the bottom -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary-custom flex-grow-1 py-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-send-fill"></i>
                            Publish Job
                        </button>
                        <button type="reset" class="btn btn-secondary-custom px-4 py-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection