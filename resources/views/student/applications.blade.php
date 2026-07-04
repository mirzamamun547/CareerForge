@extends('layouts.student')

@section('title', 'My Applications')
@section('header_title', 'My Applications')
@section('header_subtitle', 'Track the status of all your job applications.')

@push('styles')
<style>
    .app-table th {
        font-size: 0.72rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.65rem 1rem;
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        white-space: nowrap;
    }
    .app-table td {
        font-size: 0.84rem;
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
        color: #2D3142;
    }
    .app-table tbody tr:last-child td { border-bottom: none; }
    .app-table tbody tr:hover td { background: #F9FAFB; }
    
    .status-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.32em 0.85em;
        border-radius: 50rem;
        white-space: nowrap;
        display: inline-block;
    }
    .status-applied       { background:#F3F4F6; color:#6B7280; }
    .status-under-review  { background:#FEF3C7; color:#D97706; }
    .status-shortlisted   { background:#DBEAFE; color:#2563EB; }
    .status-interview     { background:#EEF2FF; color:#4F46E5; }
    .status-rejected      { background:#FFF1F2; color:#F43F5E; }
    .status-hired         { background:#ECFDF5; color:#10B981; }
    .status-withdrawn     { background:#E5E7EB; color:#4B5563; }

    .view-btn {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 0.5rem;
        border: 1.5px solid #E5E7EB;
        background: #fff;
        color: #4B5563;
        transition: all 0.18s;
        white-space: nowrap;
    }
    .view-btn:hover { border-color: #4F46E5; color: #4F46E5; background: #EEF2FF; }
    
    .company-logo-sm {
        width: 2rem; height: 2rem;
        border-radius: 0.4rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 800;
        flex-shrink: 0;
    }
    
    /* Stepper Styling */
    .stepper {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 1.5rem;
        padding-top: 1rem;
    }
    .stepper::before {
        content: '';
        position: absolute;
        top: 26px;
        left: 5%;
        right: 5%;
        height: 2px;
        background-color: #E5E7EB;
        z-index: 1;
    }
    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 20%;
    }
    .step-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #E5E7EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #9CA3AF;
        transition: all 0.3s ease;
    }
    .step-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9CA3AF;
        margin-top: 0.5rem;
        text-align: center;
        white-space: nowrap;
    }
    
    /* Stepper Active/Completed classes */
    .step-item.completed .step-icon {
        background-color: #4F46E5;
        border-color: #4F46E5;
        color: #fff;
    }
    .step-item.completed .step-label {
        color: #4F46E5;
    }
    .step-item.active .step-icon {
        border-color: #4F46E5;
        color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }
    .step-item.active .step-label {
        color: #4F46E5;
    }
    .step-item.rejected .step-icon {
        background-color: #F43F5E;
        border-color: #F43F5E;
        color: #fff;
    }
    .step-item.rejected .step-label {
        color: #F43F5E;
    }

    .filter-tab {
        font-size: 0.8rem; font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 0.5rem;
        border: none; background: transparent;
        color: #6B7280;
        transition: all 0.18s;
        text-decoration: none;
        display: inline-block;
    }
    .filter-tab:hover { background: #EEF2FF; color: #4F46E5; }
    .filter-tab.active { background: #EEF2FF; color: #4F46E5; }
    
    .stat-card-mini {
        padding: 1.25rem;
        border-radius: 1rem;
        border: 1px solid #E5E7EB;
        background-color: #fff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0 d-flex flex-column gap-4">
    @if(session('status') == 'application-withdrawn')
        <div class="alert alert-warning alert-dismissible fade show border-0 rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Application withdrawn successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="stat-card-mini d-flex align-items-center gap-3">
                <div class="icon-shape rounded-3" style="background:#EEF2FF; color:#4F46E5;">
                    <i class="bi bi-folder2-open fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $counts['all'] }}</h5>
                    <p class="text-secondary mb-0" style="font-size:0.7rem; font-weight:600;">Total Applied</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-mini d-flex align-items-center gap-3">
                <div class="icon-shape rounded-3" style="background:#FEF3C7; color:#D97706;">
                    <i class="bi bi-hourglass-split fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $counts['Under Review'] + $counts['Applied'] }}</h5>
                    <p class="text-secondary mb-0" style="font-size:0.7rem; font-weight:600;">Under Review</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-mini d-flex align-items-center gap-3">
                <div class="icon-shape rounded-3" style="background:#EEF2FF; color:#4F46E5;">
                    <i class="bi bi-camera-video fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $counts['Interview'] }}</h5>
                    <p class="text-secondary mb-0" style="font-size:0.7rem; font-weight:600;">Interviews</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-mini d-flex align-items-center gap-3">
                <div class="icon-shape rounded-3" style="background:#ECFDF5; color:#10B981;">
                    <i class="bi bi-patch-check fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $counts['Hired'] }}</h5>
                    <p class="text-secondary mb-0" style="font-size:0.7rem; font-weight:600;">Job Offers</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Applications Tracker Card for Latest Application --}}
    @php $latestApp = auth()->user()->jobApplications()->with('jobListing.user')->latest()->first(); @endphp
    @if($latestApp && $latestApp->status !== 'Withdrawn' && $latestApp->status !== 'Rejected')
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">
                        <i class="bi bi-diagram-3-fill me-2" style="color:#4F46E5;"></i>Active Application Progress
                    </h6>
                    <p class="text-secondary mb-0 mt-1" style="font-size:0.78rem;">Tracking latest application for <strong>{{ $latestApp->jobListing->title }}</strong> at <strong>{{ $latestApp->jobListing->user->name ?? 'Company' }}</strong>.</p>
                </div>
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $latestApp->status)) }}">{{ $latestApp->status }}</span>
            </div>

            <!-- Horizontal Stepper for Active Job -->
            <div class="stepper my-3">
                <div class="step-item {{ in_array($latestApp->status, ['Applied', 'Under Review', 'Shortlisted', 'Interview', 'Hired']) ? 'completed' : '' }} {{ $latestApp->status === 'Applied' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-send"></i></div>
                    <div class="step-label">Applied</div>
                </div>
                <div class="step-item {{ in_array($latestApp->status, ['Under Review', 'Shortlisted', 'Interview', 'Hired']) ? 'completed' : '' }} {{ $latestApp->status === 'Under Review' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-hourglass-split"></i></div>
                    <div class="step-label">Review</div>
                </div>
                <div class="step-item {{ in_array($latestApp->status, ['Shortlisted', 'Interview', 'Hired']) ? 'completed' : '' }} {{ $latestApp->status === 'Shortlisted' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-star"></i></div>
                    <div class="step-label">Shortlisted</div>
                </div>
                <div class="step-item {{ in_array($latestApp->status, ['Interview', 'Hired']) ? 'completed' : '' }} {{ $latestApp->status === 'Interview' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-camera-video"></i></div>
                    <div class="step-label">Interview</div>
                </div>
                <div class="step-item {{ $latestApp->status === 'Hired' ? 'completed' : '' }} {{ $latestApp->status === 'Hired' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-check-circle"></i></div>
                    <div class="step-label">Hired</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Applications Table --}}
    <div class="card card-custom overflow-hidden">
        <div class="d-flex align-items-center justify-content-between p-4 pb-0 flex-wrap gap-2">
            <h6 class="fw-bold text-dark m-0" style="font-size:0.95rem;">All Applications</h6>
            <div class="d-flex gap-1 flex-wrap">
                @php $currentStatus = request('status', 'all'); @endphp
                <a href="?status=all" class="filter-tab {{ $currentStatus == 'all' ? 'active' : '' }}">All ({{ $counts['all'] }})</a>
                <a href="?status=Applied" class="filter-tab {{ $currentStatus == 'Applied' ? 'active' : '' }}">Applied ({{ $counts['Applied'] }})</a>
                <a href="?status=Under Review" class="filter-tab {{ $currentStatus == 'Under Review' ? 'active' : '' }}">Review ({{ $counts['Under Review'] }})</a>
                <a href="?status=Shortlisted" class="filter-tab {{ $currentStatus == 'Shortlisted' ? 'active' : '' }}">Shortlisted ({{ $counts['Shortlisted'] }})</a>
                <a href="?status=Interview" class="filter-tab {{ $currentStatus == 'Interview' ? 'active' : '' }}">Interview ({{ $counts['Interview'] }})</a>
                <a href="?status=Hired" class="filter-tab {{ $currentStatus == 'Hired' ? 'active' : '' }}">Hired ({{ $counts['Hired'] }})</a>
                <a href="?status=Rejected" class="filter-tab {{ $currentStatus == 'Rejected' ? 'active' : '' }}">Rejected ({{ $counts['Rejected'] }})</a>
                <a href="?status=Withdrawn" class="filter-tab {{ $currentStatus == 'Withdrawn' ? 'active' : '' }}">Withdrawn ({{ $counts['Withdrawn'] }})</a>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table app-table mb-0" id="appTable">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Applied Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="company-logo-sm" style="background:#EEF2FF; color:#4F46E5;">
                                        {{ strtoupper(substr($application->jobListing->title ?? 'J', 0, 2)) }}
                                    </div>
                                    <span class="fw-semibold">{{ $application->jobListing->title }}</span>
                                </div>
                            </td>
                            <td class="text-secondary">{{ $application->jobListing->user->name ?? 'Company' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $application->status)) }}">
                                    {{ $application->status }}
                                </span>
                            </td>
                            <td class="text-secondary">{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="view-btn view-details-btn" 
                                    data-id="{{ $application->id }}"
                                    data-title="{{ $jobTitle = $application->jobListing->title }}"
                                    data-company="{{ $companyName = $application->jobListing->user->name ?? 'Company' }}"
                                    data-status="{{ $application->status }}"
                                    data-date="{{ $application->created_at->format('d M Y') }}"
                                    data-cover="{{ $application->cover_letter ?? 'No cover letter submitted.' }}"
                                    data-salary="${{ number_format($application->jobListing->min_salary) }} – ${{ number_format($application->jobListing->max_salary) }}"
                                    data-location="{{ $application->jobListing->location }}"
                                    data-type="{{ $application->jobListing->job_type }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-secondary">No job applications found matching filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($applications->hasPages())
            <div class="d-flex justify-content-center p-3 border-top border-light">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Detail Modal --}}
<div class="modal fade" id="appDetailsModal" tabindex="-1" aria-labelledby="appDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="appDetailsModalLabel" style="font-size:1.05rem;">
                    <i class="bi bi-briefcase-fill me-2" style="color:#4F46E5;"></i>Application Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                
                {{-- Detail Fields --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <small class="text-secondary fw-semibold">Job Title</small>
                        <h6 class="fw-bold text-dark" id="modalJobTitle">-</h6>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary fw-semibold">Company Name</small>
                        <h6 class="fw-bold text-dark" id="modalCompany">-</h6>
                    </div>
                    <div class="col-md-4">
                        <small class="text-secondary fw-semibold">Job Type / Location</small>
                        <p class="text-dark mb-0 font-semibold" style="font-size: 0.85rem;" id="modalJobDetails">-</p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-secondary fw-semibold">Salary Range</small>
                        <p class="text-success mb-0 fw-bold" style="font-size: 0.85rem;" id="modalSalary">-</p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-secondary fw-semibold">Applied Date</small>
                        <p class="text-dark mb-0" style="font-size: 0.85rem;" id="modalDate">-</p>
                    </div>
                </div>

                {{-- Status Stepper --}}
                <div class="border-top border-bottom py-4 mb-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.85rem;">Application Progress Timeline</h6>
                    
                    <div class="stepper" id="modalStepper">
                        <div class="step-item" id="step1">
                            <div class="step-icon"><i class="bi bi-send"></i></div>
                            <div class="step-label">Applied</div>
                        </div>
                        <div class="step-item" id="step2">
                            <div class="step-icon"><i class="bi bi-hourglass-split"></i></div>
                            <div class="step-label">Review</div>
                        </div>
                        <div class="step-item" id="step3">
                            <div class="step-icon"><i class="bi bi-star"></i></div>
                            <div class="step-label">Shortlisted</div>
                        </div>
                        <div class="step-item" id="step4">
                            <div class="step-icon"><i class="bi bi-camera-video"></i></div>
                            <div class="step-label">Interview</div>
                        </div>
                        <div class="step-item" id="step5">
                            <div class="step-icon"><i class="bi bi-check-circle"></i></div>
                            <div class="step-label">Hired</div>
                        </div>
                    </div>
                </div>

                {{-- Cover Letter --}}
                <div class="mb-2">
                    <small class="text-secondary fw-semibold d-block mb-1">Submitted Cover Letter</small>
                    <div class="p-3 bg-light rounded-3 text-secondary" style="font-size:0.85rem; max-height:200px; overflow-y:auto; white-space: pre-wrap;" id="modalCoverLetter">
                        -
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-0 pt-0 justify-content-between">
                <div>
                    <form id="withdrawForm" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger-custom btn-sm py-2 px-3 fw-bold" id="withdrawBtn" style="border: 1.5px solid #F43F5E; background: #FFF1F2; color: #F43F5E; border-radius: 0.5rem;">
                            <i class="bi bi-x-circle me-1"></i>Withdraw Application
                        </button>
                    </form>
                </div>
                <button type="button" class="btn btn-secondary-custom btn-sm py-2 px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle view details click and map to modal fields
    document.querySelectorAll('.view-details-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = this.dataset;
            
            document.getElementById('modalJobTitle').textContent = data.title;
            document.getElementById('modalCompany').textContent = data.company;
            document.getElementById('modalJobDetails').textContent = `${data.type} • ${data.location}`;
            document.getElementById('modalSalary').textContent = data.salary;
            document.getElementById('modalDate').textContent = data.date;
            document.getElementById('modalCoverLetter').textContent = data.cover;

            // Setup withdraw action
            const withdrawForm = document.getElementById('withdrawForm');
            withdrawForm.action = `/student/applications/${data.id}/withdraw`;

            // Display / hide withdraw button based on status
            const status = data.status;
            const withdrawBtn = document.getElementById('withdrawBtn');
            
            if (status === 'Withdrawn' || status === 'Rejected' || status === 'Hired') {
                withdrawForm.style.display = 'none';
            } else {
                withdrawForm.style.display = 'block';
            }

            // Stepper state updates
            const steps = ['Applied', 'Under Review', 'Shortlisted', 'Interview', 'Hired'];
            const stepIndex = steps.indexOf(status);

            // Reset step elements
            const stepItems = [
                document.getElementById('step1'),
                document.getElementById('step2'),
                document.getElementById('step3'),
                document.getElementById('step4'),
                document.getElementById('step5')
            ];

            stepItems.forEach(el => {
                el.className = 'step-item';
            });

            if (status === 'Withdrawn') {
                // Show as all grayed out/neutral
            } else if (status === 'Rejected') {
                // Turn active steps red/rejected
                stepItems[0].classList.add('completed');
                stepItems[1].className = 'step-item rejected';
                stepItems[1].querySelector('.step-icon').innerHTML = '<i class="bi bi-x-lg"></i>';
                stepItems[1].querySelector('.step-label').textContent = 'Rejected';
            } else {
                // Restore standard review icon
                document.getElementById('step2').querySelector('.step-icon').innerHTML = '<i class="bi bi-hourglass-split"></i>';
                document.getElementById('step2').querySelector('.step-label').textContent = 'Review';

                stepItems.forEach((el, index) => {
                    if (index < stepIndex) {
                        el.classList.add('completed');
                    } else if (index === stepIndex) {
                        el.classList.add('active');
                    }
                });
            }

            // Show details modal
            const detailsModal = new bootstrap.Modal(document.getElementById('appDetailsModal'));
            detailsModal.show();
        });
    });

    // Handle withdraw confirmations
    document.getElementById('withdrawForm').addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
</script>
@endpush