@extends('layouts.employer')

@section('title', 'Applicants List')
@section('header_title', 'Applicants')
@section('header_subtitle', 'Review and manage all applicants who applied for your jobs.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">
        
        <!-- Toolbar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">Job:</span>
                <select class="form-select form-control-custom" style="width: 200px;">
                    <option>All Jobs</option>
                    <option>Backend Developer</option>
                    <option>Laravel Developer</option>
                    <option>UI/UX Designer</option>
                </select>
                <button class="btn btn-outline-secondary d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem;">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>
            </div>
            
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-secondary" style="top: 50%; left: 1rem; transform: translateY(-50%);"></i>
                <input type="text" class="form-control form-control-custom ps-5" placeholder="Search applicants..." style="width: 250px;">
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Applicant</th>
                        <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Job Applied</th>
                        <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Applied On</th>
                        <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Status</th>
                        <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                    RU
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Raihan Uddin</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">Backend Developer</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">Backend Developer</td>
                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">16 May 2024</td>
                        <td class="py-3"><span class="badge-custom-amber">Under Review</span></td>
                        <td class="py-3">
                            <a href="/employer/applicant-details" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                    TI
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Tasnimul Islam</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">Laravel Developer</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">Laravel Developer</td>
                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">15 May 2024</td>
                        <td class="py-3"><span class="badge-custom-emerald">Shortlisted</span></td>
                        <td class="py-3">
                            <a href="/employer/applicant-details" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                    SA
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Sadia Akter</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">UI/UX Designer</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">UI/UX Designer</td>
                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">14 May 2024</td>
                        <td class="py-3"><span class="badge-custom-indigo">Interview</span></td>
                        <td class="py-3">
                            <a href="/employer/applicant-details" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                    HH
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Hasibul Hasan</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">PHP Developer</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">PHP Developer</td>
                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">13 May 2024</td>
                        <td class="py-3"><span class="badge-custom-indigo">Applied</span></td>
                        <td class="py-3">
                            <a href="/employer/applicant-details" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                    NH
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">Nayeem Hossain</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">Backend Developer</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">Backend Developer</td>
                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">12 May 2024</td>
                        <td class="py-3"><span class="badge-custom-rose">Rejected</span></td>
                        <td class="py-3">
                            <a href="/employer/applicant-details" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#" style="background-color: #4F46E5; border-color: #4F46E5;">1</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link text-dark" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
