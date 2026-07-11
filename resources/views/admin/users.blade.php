@extends('layouts.admin')

@section('title', 'Manage Users')
@section('header_title', 'Manage Users')
@section('header_subtitle', 'View, search, and moderate student & employer accounts')

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
            <a href="{{ route('admin.users', ['role' => 'all']) }}" class="tab-pill {{ $currentTab === 'all' ? 'active' : '' }}">All ({{ $counts['all'] }})</a>
            <a href="{{ route('admin.users', ['role' => 'student']) }}" class="tab-pill {{ $currentTab === 'student' ? 'active' : '' }}">Students ({{ $counts['student'] }})</a>
            <a href="{{ route('admin.users', ['role' => 'employer']) }}" class="tab-pill {{ $currentTab === 'employer' ? 'active' : '' }}">Employers ({{ $counts['employer'] }})</a>
            <a href="{{ route('admin.users', ['role' => 'suspended']) }}" class="tab-pill {{ $currentTab === 'suspended' ? 'active' : '' }}">Suspended ({{ $counts['suspended'] }})</a>
        </div>
        <form method="GET" action="{{ route('admin.users') }}" class="search-wrap">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="search" placeholder="Search name or email..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight:700;">{{ $user->name }}</td>
                        <td style="color:var(--muted);">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge-custom-rose">Admin</span>
                            @elseif($user->role === 'employer')
                                <span class="badge-custom-emerald">Employer</span>
                            @else
                                <span class="badge-custom-indigo">Student</span>
                            @endif
                        </td>
                        <td style="color:var(--muted);">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                        <td>
                            @if($user->status === 'suspended')
                                <span class="badge-custom-rose">Suspended</span>
                            @else
                                <span class="badge-custom-emerald">Active</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">View</button>
                                @if($user->role !== 'admin')
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                        @csrf
                                        @if($user->status === 'suspended')
                                            <button type="submit" class="btn-emerald-custom border-0">Activate</button>
                                        @else
                                            <button type="submit" class="btn-rose-custom border-0">Suspend</button>
                                        @endif
                                    </form>
                                @endif
                            </div>

                            <!-- User details Modal -->
                            <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold text-dark m-0">User Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-4">
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                <div class="avatar-dot" style="width: 3.5rem; height: 3.5rem; font-size: 1.2rem;">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark m-0 fs-5">{{ $user->name }}</h6>
                                                    <span class="text-secondary" style="font-size:0.8rem;">Role: {{ ucfirst($user->role) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-2" style="font-size: 0.88rem;">
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Email</span>
                                                    <span class="fw-bold text-dark">{{ $user->email }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Phone</span>
                                                    <span class="fw-bold text-dark">{{ $user->phone ?? '—' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-secondary">Joined Date</span>
                                                    <span class="fw-bold text-dark">{{ optional($user->created_at)->format('d M Y, h:i A') ?? '-' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between pb-2">
                                                    <span class="text-secondary">Account Status</span>
                                                    <span class="fw-bold {{ $user->status === 'suspended' ? 'text-danger' : 'text-success' }}">{{ ucfirst($user->status ?? 'active') }}</span>
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
                        <td colspan="6" class="text-center py-4 text-secondary">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
