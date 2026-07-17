@extends('layouts.admin')

@section('title', 'Manage Jobs')
@section('header_title', 'Manage Jobs')
@section('header_subtitle', 'Moderate listings, handle reports, and remove policy-violating posts')

@section('content')
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-custom p-4">
    <div class="toolbar d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="tab-pills">
            <a href="{{ route('admin.jobs', ['status' => 'all']) }}" class="tab-pill {{ $currentTab === 'all' ? 'active' : '' }}">All ({{ $counts['all'] }})</a>
            <a href="{{ route('admin.jobs', ['status' => 'reported']) }}" class="tab-pill {{ $currentTab === 'reported' ? 'active' : '' }}">Reported ({{ $counts['reported'] }})</a>
            <a href="{{ route('admin.jobs', ['status' => 'closed']) }}" class="tab-pill {{ $currentTab === 'closed' ? 'active' : '' }}">Closed ({{ $counts['closed'] }})</a>
        </div>
        <form method="GET" action="{{ route('admin.jobs') }}" class="search-wrap">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="search" placeholder="Search jobs..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Category</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td style="font-weight:700;">{{ $job->title }}</td>
                        <td style="color:var(--muted);">{{ $job->user->employerProfile->company_name ?? $job->user->name }}</td>
                        <td><span class="badge-custom-indigo">{{ $job->category }}</span></td>
                        <td>{{ $job->applications()->count() }}</td>
                        <td>
                            @if(strtolower($job->status) === 'reported')
                                <span class="badge-custom-rose">Reported</span>
                            @elseif(strtolower($job->status) === 'active')
                                <span class="badge-custom-emerald">Active</span>
                            @else
                                <span class="badge-custom-gray">Closed</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">View</button>
                                @if(strtolower($job->status) === 'reported')
                                    <form method="POST" action="{{ route('admin.jobs.dismiss-report', $job) }}">
                                        @csrf
                                        <button type="submit" class="btn-emerald-custom border-0">Dismiss Report</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.jobs.remove', $job) }}">
                                    @csrf
                                    <button type="submit" class="btn-rose-custom border-0">Remove</button>
                                </form>
                            </div>

                            <!-- Job details Modal -->
                            <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold text-dark m-0">Job Listing Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-4">
                                            <div class="mb-4">
                                                <h6 class="fw-bold text-dark mb-1 fs-5">{{ $job->title }}</h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-secondary" style="font-size:0.8rem;">Posted by: {{ $job->user->name }}</span>
                                                    <span class="badge-custom-indigo" style="font-size:0.7rem;">{{ $job->job_type }}</span>
                                                    <span class="badge-custom-gray" style="font-size:0.7rem;"><i class="bi bi-geo-alt"></i> {{ $job->location }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 style-scroll mb-4" style="font-size: 0.88rem;">
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                        <span class="text-secondary">Category</span>
                                                        <span class="fw-bold text-dark">{{ $job->category }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                        <span class="text-secondary">Salary Range</span>
                                                        <span class="fw-bold text-dark">${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                        <span class="text-secondary">Deadline</span>
                                                        <span class="fw-bold text-dark">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '—' }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                        <span class="text-secondary">Status</span>
                                                        <span class="fw-bold text-dark">{{ ucfirst($job->status) }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-top border-light pt-3 mb-4" style="font-size: 0.88rem;">
                                                <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;"><i class="bi bi-geo-alt-fill text-primary"></i> Verified Location Coordinates</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                            <span class="text-secondary">City</span>
                                                            <span class="fw-bold text-dark">{{ $job->city ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between border-bottom pb-2">
                                                            <span class="text-secondary">Country</span>
                                                            <span class="fw-bold text-dark">{{ $job->country ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                                            <span class="text-secondary">Latitude</span>
                                                            <span class="fw-bold text-dark">{{ $job->latitude ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between border-bottom pb-2">
                                                            <span class="text-secondary">Longitude</span>
                                                            <span class="fw-bold text-dark">{{ $job->longitude ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;">Description</h6>
                                                <div class="p-3 rounded bg-light text-secondary" style="font-size:0.85rem; max-height: 150px; overflow-y: auto;">
                                                    {{ $job->description }}
                                                </div>
                                            </div>

                                            @if($job->requirements)
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-dark mb-2" style="font-size:0.9rem;">Requirements</h6>
                                                    <div class="p-3 rounded bg-light text-secondary" style="font-size:0.85rem; max-height: 150px; overflow-y: auto;">
                                                        {{ $job->requirements }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-secondary">No job listings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
