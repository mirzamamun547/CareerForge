@extends('layouts.employer')

@section('title', 'Applicants List')
@section('header_title', 'Applicants')
@section('header_subtitle', 'Review and manage all applicants who applied for your jobs.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">
        
        <!-- Toolbar / Filters -->
        <form action="{{ route('employer.applicants') }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label text-secondary fw-semibold mb-1" style="font-size: 0.8rem;">Filter by Job Posting</label>
                    <select name="job_id" class="form-select form-control-custom">
                        <option value="">All Jobs</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                {{ $job->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label text-secondary fw-semibold mb-1" style="font-size: 0.8rem;">Filter by Status</label>
                    <select name="status" class="form-select form-control-custom">
                        <option value="">All Statuses</option>
                        <option value="Applied" {{ request('status') === 'Applied' ? 'selected' : '' }}>Applied</option>
                        <option value="Under Review" {{ request('status') === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Shortlisted" {{ request('status') === 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="Interview" {{ request('status') === 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Hired" {{ request('status') === 'Hired' ? 'selected' : '' }}>Hired</option>
                        <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Withdrawn" {{ request('status') === 'Withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom flex-grow-1" style="padding: 0.65rem 1rem;">
                        <i class="bi bi-funnel-fill me-1"></i> Apply Filters
                    </button>
                    @if(request()->anyFilled(['job_id', 'status']))
                        <a href="{{ route('employer.applicants') }}" class="btn btn-secondary-custom d-flex align-items-center justify-content-center" style="padding: 0.65rem 1rem;">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>

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
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 40px; height: 40px; flex-shrink: 0;">
                                        {{ strtoupper(substr($application->student->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $application->student->name }}</h6>
                                        <span class="text-secondary" style="font-size: 0.75rem;">{{ $application->student->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">{{ $application->jobListing->title }}</td>
                            <td class="py-3 text-secondary" style="font-size: 0.85rem;">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                @php
                                    $statusClass = 'badge-custom-amber';
                                    if ($application->status === 'Hired') {
                                        $statusClass = 'badge-custom-emerald';
                                    } elseif ($application->status === 'Rejected') {
                                        $statusClass = 'badge-custom-rose';
                                    } elseif ($application->status === 'Shortlisted' || $application->status === 'Interview') {
                                        $statusClass = 'badge-custom-indigo';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} py-1 px-3 rounded-pill fw-bold" style="font-size: 0.72rem;">
                                    {{ $application->status }}
                                </span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('employer.applicant-details', $application) }}" class="btn btn-sm btn-light border rounded-3" title="View details">
                                    <i class="bi bi-eye"></i> Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <i class="bi bi-people-fill display-6 text-muted mb-3 d-block"></i>
                                <p class="mb-0">No matching applications found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $applications->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
