@extends('layouts.employer')

@section('title', 'Manage Jobs')
@section('header_title', 'Manage Jobs')
@section('header_subtitle', 'Review and update your current job listings.')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom p-4">
                
                <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-3 mb-4">
                    <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">Active & Inactive Jobs</h5>
                    <a href="/employer/jobs" class="btn btn-primary-custom d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
                        <i class="bi bi-plus-circle"></i>
                        Post a New Job
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light-head">
                            <tr style="border-bottom: 2px solid #F3F4F6;">
                                <th class="text-secondary fw-semibold py-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">JOB TITLE</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">TYPE</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">STATUS</th>
                                <th class="text-secondary text-end fw-semibold py-3" style="font-size: 0.8rem; letter-spacing: 0.05em;">ACTION</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($jobs as $job)
                                <tr style="border-bottom: 1px solid #F3F4F6;">
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $job->title }}</div>
                                        <div class="text-secondary" style="font-size: 0.75rem;">Posted on {{ $job->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark px-2.5 py-1.5 rounded fw-medium" style="font-size: 0.75rem; border: 1px solid #E5E7EB;">{{ $job->job_type }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="{{ $job->status === 'Active' ? 'badge-custom-emerald' : 'badge-custom-rose' }}">{{ $job->status }}</span>
                                    </td>
                                    <td class="py-3 text-end">
                                        <button class="btn btn-warning-custom d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $job->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editJobModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                                      <div class="modal-header border-0 bg-light p-4">
                                        <h5 class="fw-bold text-dark m-0" style="font-size: 1.15rem;">Edit Job Posting</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body p-4">
                                        <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Title</label>
                                                <input type="text" name="title" class="form-control form-control-custom" value="{{ $job->title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Category</label>
                                                <input type="text" name="category" class="form-control form-control-custom" value="{{ $job->category }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Type</label>
                                                <select name="job_type" class="form-select form-control-custom">
                                                    <option {{ $job->job_type === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                                    <option {{ $job->job_type === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                                    <option {{ $job->job_type === 'Internship' ? 'selected' : '' }}>Internship</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Location</label>
                                                <input type="text" name="location" class="form-control form-control-custom" value="{{ $job->location }}" required>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col">
                                                    <input type="number" name="min_salary" class="form-control form-control-custom" value="{{ $job->min_salary }}" required>
                                                </div>
                                                <div class="col">
                                                    <input type="number" name="max_salary" class="form-control form-control-custom" value="{{ $job->max_salary }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Description</label>
                                                <textarea name="description" class="form-control form-control-custom" rows="4" required>{{ $job->description }}</textarea>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Status</label>
                                                <select name="status" class="form-select form-control-custom">
                                                    <option {{ $job->status === 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option {{ $job->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer border-0 p-4 pt-4">
                                                <button type="button" class="btn btn-secondary-custom px-4 py-2.5" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary-custom px-4 py-2.5">Update Job</button>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-secondary">No jobs yet. Post your first listing to get started.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
