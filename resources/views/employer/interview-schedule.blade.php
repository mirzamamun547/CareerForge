@extends('layouts.employer')

@section('title', 'Interview Schedule')
@section('header_title', 'Interview Schedule')
@section('header_subtitle', 'View and manage all upcoming interviews.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        <!-- Upcoming Interviews Table -->
        <div class="col-12">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">Upcoming Interviews</h5>
                    <a href="/employer/schedule-interview" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                        <i class="bi bi-plus-lg"></i>
                        Schedule New Interview
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Applicant</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Job Title</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Date</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Time</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Type</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Status</th>
                                <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                            RU
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">Raihan Uddin</span>
                                    </div>
                                </td>
                                <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">Backend Developer</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">23 May 2024</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">10:00 AM</td>
                                <td class="py-3"><span class="badge-custom-indigo">Online</span></td>
                                <td class="py-3"><span class="badge-custom-emerald">Scheduled</span></td>
                                <td class="py-3">
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-light border rounded-3" title="Edit"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light border rounded-3 text-danger" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                            TI
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tasnimul Islam</span>
                                    </div>
                                </td>
                                <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">Laravel Developer</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">21 May 2024</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">03:00 PM</td>
                                <td class="py-3"><span class="badge-custom-indigo">Online</span></td>
                                <td class="py-3"><span class="badge-custom-emerald">Scheduled</span></td>
                                <td class="py-3">
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-light border rounded-3" title="Edit"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light border rounded-3 text-danger" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                            SA
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">Sadia Akter</span>
                                    </div>
                                </td>
                                <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">UI/UX Designer</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">22 May 2024</td>
                                <td class="py-3 text-secondary" style="font-size: 0.85rem;">11:00 AM</td>
                                <td class="py-3"><span class="badge-custom-amber">On-site</span></td>
                                <td class="py-3"><span class="badge-custom-emerald">Scheduled</span></td>
                                <td class="py-3">
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-light border rounded-3" title="Edit"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light border rounded-3 text-danger" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#" style="background-color: #4F46E5; border-color: #4F46E5;">1</a></li>
                            <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                            <li class="page-item">
                                <a class="page-link text-dark" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
