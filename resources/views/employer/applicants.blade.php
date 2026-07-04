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
                    @forelse($applications as $application)
                        <tr>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($application->student->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $application->student->name }}</h6>
                                        <span class="text-secondary" style="font-size: 0.75rem;">{{ $application->jobListing->title }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">{{ $application->jobListing->title }}</td>
                            <td class="py-3 text-secondary" style="font-size: 0.85rem;">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="py-3"><span class="badge-custom-amber">{{ $application->status }}</span></td>
                            <td class="py-3">
                                <a href="{{ route('employer.applicant-details', $application) }}" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-secondary">No applications yet for your jobs.</td>
                        </tr>
                    @endforelse
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
