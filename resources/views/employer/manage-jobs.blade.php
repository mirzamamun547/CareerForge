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
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="py-3">
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">Laravel Developer</div>
                                    <div class="text-secondary" style="font-size: 0.75rem;">Posted on 16 May 2024</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark px-2.5 py-1.5 rounded fw-medium" style="font-size: 0.75rem; border: 1px solid #E5E7EB;">Full Time</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge-custom-emerald">Active</span>
                                </td>
                                <td class="py-3 text-end">
                                    <button class="btn btn-warning-custom d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#editJobModal">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="py-3">
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">UI/UX Designer</div>
                                    <div class="text-secondary" style="font-size: 0.75rem;">Posted on 12 May 2024</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark px-2.5 py-1.5 rounded fw-medium" style="font-size: 0.75rem; border: 1px solid #E5E7EB;">Part Time</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge-custom-rose">Inactive</span>
                                </td>
                                <td class="py-3 text-end">
                                    <button class="btn btn-warning-custom d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#editJobModal">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">

      <div class="modal-header border-0 bg-light p-4">
        <h5 class="fw-bold text-dark m-0" style="font-size: 1.15rem;">Edit Job Posting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <form id="editJobForm">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Title</label>
                <input type="text" class="form-control form-control-custom" value="Laravel Developer" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Job Type</label>
                <select class="form-select form-control-custom">
                    <option selected>Full Time</option>
                    <option>Part Time</option>
                    <option>Internship</option>
                </select>
            </div>

            <div class="mb-0">
                <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Status</label>
                <select class="form-select form-control-custom">
                    <option selected>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
        </form>
      </div>

      <div class="modal-footer border-0 p-4 pt-0">
        <button type="button" class="btn btn-secondary-custom px-4 py-2.5" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="editJobForm" class="btn btn-primary-custom px-4 py-2.5">Update Job</button>
      </div>

    </div>
  </div>
</div>
@endsection
