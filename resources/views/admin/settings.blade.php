@extends('layouts.admin')

@section('title', 'System Settings')
@section('header_title', 'System Settings')
@section('header_subtitle', 'Platform-wide configuration')

@section('content')
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-custom p-4">
    <!-- Require employer verification -->
    <div class="switch-row d-flex align-items-center justify-content-between py-3 border-bottom">
        <div>
            <div class="switch-label fw-bold" style="font-size:0.95rem;">Require employer verification</div>
            <div class="switch-desc text-secondary" style="font-size:0.78rem;">New employer accounts must be approved before posting jobs</div>
        </div>
        <form method="POST" action="{{ route('admin.settings.toggle') }}">
            @csrf
            <input type="hidden" name="key" value="require_employer_verification">
            <div class="toggle-switch {{ $settings['require_employer_verification'] ? 'on' : '' }}" onclick="this.closest('form').submit();">
                <div class="knob"></div>
            </div>
        </form>
    </div>

    <!-- Auto-close expired job listings -->
    <div class="switch-row d-flex align-items-center justify-content-between py-3 border-bottom">
        <div>
            <div class="switch-label fw-bold" style="font-size:0.95rem;">Auto-close expired job listings</div>
            <div class="switch-desc text-secondary" style="font-size:0.78rem;">Jobs past their deadline are marked closed automatically (runs daily via scheduler)</div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <form method="POST" action="{{ route('admin.settings.run-close-expired-jobs') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-light border rounded-3" style="font-size:0.78rem;">
                    <i class="bi bi-play-fill"></i> Run Now
                </button>
            </form>
            <form method="POST" action="{{ route('admin.settings.toggle') }}">
                @csrf
                <input type="hidden" name="key" value="auto_close_expired_jobs">
                <div class="toggle-switch {{ $settings['auto_close_expired_jobs'] ? 'on' : '' }}" onclick="this.closest('form').submit();">
                    <div class="knob"></div>
                </div>
            </form>
        </div>
    </div>

    <!-- Maintenance mode -->
    <div class="switch-row d-flex align-items-center justify-content-between py-3">
        <div>
            <div class="switch-label fw-bold" style="font-size:0.95rem;">Maintenance mode</div>
            <div class="switch-desc text-secondary" style="font-size:0.78rem;">Temporarily disable student/employer access</div>
        </div>
        <form method="POST" action="{{ route('admin.settings.toggle') }}">
            @csrf
            <input type="hidden" name="key" value="maintenance_mode">
            <div class="toggle-switch {{ $settings['maintenance_mode'] ? 'on' : '' }}" onclick="this.closest('form').submit();">
                <div class="knob"></div>
            </div>
        </form>
    </div>
</div>

    <!-- Admin credentials update -->
    <div class="mt-5">
        <h5 class="fw-bold mb-3">Admin Account</h5>
        <form method="POST" action="{{ route('admin.settings.updateCredentials') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email address</label>
                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">New password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
            </div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </form>
    </div>
@endsection
