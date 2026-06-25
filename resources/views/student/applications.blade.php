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
    }
    .status-under-review  { background:#FEF3C7; color:#D97706; }
    .status-shortlisted   { background:#ECFDF5; color:#10B981; }
    .status-interview     { background:#EEF2FF; color:#4F46E5; }
    .status-applied       { background:#F3F4F6; color:#6B7280; }
    .status-rejected      { background:#FFF1F2; color:#F43F5E; }
    .status-hired         { background:#ECFDF5; color:#059669; }
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
    /* Tracking stepper */
    .tracking-card { border: 1px solid #E5E7EB; border-radius: 0.85rem; padding: 1.25rem 1.35rem; background: #fff; }
    .stepper { display: flex; align-items: flex-start; gap: 0; }
    .step-item { flex: 1; display: flex; flex-direction: column; align-items: center; position: relative; }
    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 14px; left: 50%;
        width: 100%; height: 2px;
        background: #E5E7EB;
        z-index: 0;
    }
    .step-item.done:not(:last-child)::after { background: #4F46E5; }
    .step-dot {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700;
        z-index: 1;
        border: 2px solid #E5E7EB;
        background: #fff;
        color: #9CA3AF;
        position: relative;
    }
    .step-item.done .step-dot { background: #4F46E5; border-color: #4F46E5; color: #fff; }
    .step-item.active .step-dot { background: #fff; border-color: #4F46E5; color: #4F46E5; box-shadow: 0 0 0 4px rgba(79,70,229,0.15); }
    .step-label { font-size: 0.68rem; color: #9CA3AF; margin-top: 6px; text-align: center; font-weight: 600; white-space: nowrap; }
    .step-item.done .step-label, .step-item.active .step-label { color: #4F46E5; }
    .step-date { font-size: 0.62rem; color: #C4C9D4; text-align: center; margin-top: 1px; }
    .filter-tab {
        font-size: 0.8rem; font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 0.5rem;
        border: none; background: transparent;
        color: #6B7280;
        transition: all 0.18s;
        cursor: pointer;
    }
    .filter-tab.active, .filter-tab:hover { background: #EEF2FF; color: #4F46E5; }
</style>
@endpush

@section('content')
<div class="container-fluid p-0 d-flex flex-column gap-4">

    {{-- Application Tracking Card --}}
    <div class="card card-custom p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;">
                    <i class="bi bi-diagram-3-fill me-2" style="color:#4F46E5;"></i>Application Tracking
                </h6>
                <p class="text-secondary mb-0 mt-1" style="font-size:0.78rem;">Laravel Developer at Creative IT — Applied on 10 May 2024</p>
            </div>
            <span class="status-badge status-shortlisted">Shortlisted</span>
        </div>

        {{-- Stepper --}}
        <div class="stepper mb-3">
            <div class="step-item done">
                <div class="step-dot"><i class="bi bi-check-lg"></i></div>
                <div class="step-label">Applied</div>
                <div class="step-date">10 May</div>
            </div>
            <div class="step-item done">
                <div class="step-dot"><i class="bi bi-check-lg"></i></div>
                <div class="step-label">Under Review</div>
                <div class="step-date">12 May</div>
            </div>
            <div class="step-item active">
                <div class="step-dot"><i class="bi bi-star-fill" style="font-size:0.6rem;"></i></div>
                <div class="step-label">Shortlisted</div>
                <div class="step-date">16 May</div>
            </div>
            <div class="step-item">
                <div class="step-dot">4</div>
                <div class="step-label">Interview</div>
                <div class="step-date">—</div>
            </div>
            <div class="step-item">
                <div class="step-dot">5</div>
                <div class="step-label">Hired</div>
                <div class="step-date">—</div>
            </div>
        </div>

        <div class="p-3 rounded-3 mt-2" style="background:#ECFDF5; border:1px solid #A7F3D0;">
            <div class="fw-bold text-success mb-1" style="font-size:0.82rem;"><i class="bi bi-check-circle-fill me-1"></i>Current Status: Shortlisted</div>
            <div class="text-secondary" style="font-size:0.78rem;">Congratulations! You have been shortlisted. Await interview invitation.</div>
        </div>
    </div>

    {{-- Applications Table --}}
    <div class="card card-custom overflow-hidden">
        <div class="d-flex align-items-center justify-content-between p-4 pb-0 flex-wrap gap-2">
            <h6 class="fw-bold text-dark m-0" style="font-size:0.95rem;">All Applications</h6>
            <div class="d-flex gap-1">
                <button class="filter-tab active" data-filter="all">All</button>
                <button class="filter-tab" data-filter="under-review">Under Review</button>
                <button class="filter-tab" data-filter="shortlisted">Shortlisted</button>
                <button class="filter-tab" data-filter="interview">Interview</button>
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
                    <tr data-status="under-review">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="company-logo-sm" style="background:#EEF2FF; color:#4F46E5;">TS</div>
                                <span class="fw-semibold">Junior PHP Developer</span>
                            </div>
                        </td>
                        <td class="text-secondary">TechSoft Ltd</td>
                        <td><span class="status-badge status-under-review">Under Review</span></td>
                        <td class="text-secondary">12 May 2024</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr data-status="shortlisted">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="company-logo-sm" style="background:#ECFDF5; color:#10B981;">CI</div>
                                <span class="fw-semibold">Laravel Developer</span>
                            </div>
                        </td>
                        <td class="text-secondary">Creative IT</td>
                        <td><span class="status-badge status-shortlisted">Shortlisted</span></td>
                        <td class="text-secondary">10 May 2024</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr data-status="interview">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="company-logo-sm" style="background:#FEF3C7; color:#D97706;">BS</div>
                                <span class="fw-semibold">Web Developer</span>
                            </div>
                        </td>
                        <td class="text-secondary">Brain Station 23</td>
                        <td><span class="status-badge status-interview">Interview</span></td>
                        <td class="text-secondary">08 May 2024</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr data-status="applied">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="company-logo-sm" style="background:#F3F4F6; color:#6B7280;">SC</div>
                                <span class="fw-semibold">PHP Developer</span>
                            </div>
                        </td>
                        <td class="text-secondary">SoftCloud</td>
                        <td><span class="status-badge status-applied">Applied</span></td>
                        <td class="text-secondary">05 May 2024</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                    <tr data-status="rejected">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="company-logo-sm" style="background:#FFF1F2; color:#F43F5E;">DH</div>
                                <span class="fw-semibold">Backend Developer</span>
                            </div>
                        </td>
                        <td class="text-secondary">DevHub</td>
                        <td><span class="status-badge status-rejected">Rejected</span></td>
                        <td class="text-secondary">03 May 2024</td>
                        <td><button class="view-btn">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('#appTable tbody tr').forEach(row => {
                row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
            });
        });
    });
</script>
@endpush