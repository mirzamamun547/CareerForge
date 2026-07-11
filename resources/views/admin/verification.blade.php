@extends('layouts.admin')

@section('title', 'Employer Verification')
@section('header_title', 'Employer Verification')
@section('header_subtitle', 'Approve new companies before they can post jobs')

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
            <a href="{{ route('admin.verification', ['status' => 'pending']) }}" class="tab-pill {{ $currentTab === 'pending' ? 'active' : '' }}">Pending ({{ $counts['pending'] }})</a>
            <a href="{{ route('admin.verification', ['status' => 'approved']) }}" class="tab-pill {{ $currentTab === 'approved' ? 'active' : '' }}">Approved ({{ $counts['approved'] }})</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Industry</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employers as $employer)
                    @php $profile = $employer->employerProfile; @endphp
                    <tr>
                        <td style="font-weight:700;">
                            @if($profile && $profile->company_name)
                                {{ $profile->company_name }}
                            @else
                                {{ $employer->name }}
                            @endif
                        </td>
                        <td>{{ $profile->contact_person ?? '—' }}</td>
                        <td style="color:var(--muted);">{{ $profile->company_email ?? $employer->email }}</td>
                        <td>
                            @if($profile && $profile->industry)
                                <span class="badge-custom-gray">{{ $profile->industry }}</span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td style="color:var(--muted);">{{ $employer->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#employerModal{{ $employer->id }}">View</button>
                                @if(!$employer->verified)
                                    <form method="POST" action="{{ route('admin.verification.approve', $employer) }}">
                                        @csrf
                                        <button type="submit" class="btn-emerald-custom border-0">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.verification.reject', $employer) }}">
                                        @csrf
                                        <button type="submit" class="btn-rose-custom border-0">Reject</button>
                                    </form>
                                @else
                                    <span class="badge-custom-emerald"><i class="bi bi-check-circle-fill"></i> Approved</span>
                                @endif
                            </div>

                            <!-- Employer details Modal -->
                            <div class="modal fade" id="employerModal{{ $employer->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold text-dark m-0">Company Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                @if($profile && $profile->company_logo)
                                                    <img src="{{ asset('storage/' . $profile->company_logo) }}" alt="Logo" class="rounded border object-fit-cover" style="width: 3.5rem; height: 3.5rem;">
                                                @else
                                                    <div class="avatar-dot" style="width: 3.5rem; height: 3.5rem; font-size: 1.2rem;">
                                                        {{ strtoupper(substr($profile->company_name ?? $employer->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="fw-bold text-dark m-0 fs-5">{{ $profile->company_name ?? $employer->name }}</h6>
                                                    <span class="text-secondary" style="font-size:0.8rem;">Industry: {{ $profile->industry ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-2" style="font-size: 0.88rem;">
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Website</span>
                                                    <span class="fw-bold text-dark">
                                                        @if($profile && $profile->website)
                                                            <a href="{{ $profile->website }}" target="_blank" class="text-decoration-none text-primary">{{ $profile->website }}</a>
                                                        @else
                                                            —
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Company Email</span>
                                                    <span class="fw-bold text-dark">{{ $profile->company_email ?? $employer->email }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Contact Person</span>
                                                    <span class="fw-bold text-dark">{{ $profile->contact_person ?? '—' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Address</span>
                                                    <span class="fw-bold text-dark text-end" style="max-width: 60%;">{{ $profile->company_address ?? '—' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between pb-2">
                                                    <span class="text-secondary">Verification Status</span>
                                                    <span class="fw-bold {{ $employer->verified ? 'text-success' : 'text-warning' }}">
                                                        {{ $employer->verified ? 'Approved' : 'Pending' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-secondary">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $employers->links() }}
    </div>
</div>
@endsection
