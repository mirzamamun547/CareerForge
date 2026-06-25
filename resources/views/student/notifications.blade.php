@extends('layouts.student')

@section('title', 'Notifications')
@section('header_title', 'Notifications')
@section('header_subtitle', 'Stay updated with your latest activity.')

@push('styles')
<style>
    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #F3F4F6;
        transition: background 0.18s;
        cursor: pointer;
        position: relative;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #F9FAFB; }
    .notif-item.unread { background: #FAFBFF; }
    .notif-item.unread::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: #4F46E5;
        border-radius: 0 2px 2px 0;
    }
    .notif-icon {
        width: 2.4rem; height: 2.4rem;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .notif-title { font-size: 0.85rem; font-weight: 600; color: #2D3142; margin-bottom: 0.15rem; }
    .notif-desc  { font-size: 0.78rem; color: #6B7280; margin: 0; }
    .notif-time  { font-size: 0.7rem; color: #9CA3AF; white-space: nowrap; flex-shrink: 0; }
    .unread-dot  {
        width: 8px; height: 8px;
        border-radius: 50%; background: #4F46E5;
        flex-shrink: 0; margin-top: 6px;
    }
    .mark-all-btn {
        font-size: 0.8rem; font-weight: 700; color: #4F46E5;
        border: none; background: none; padding: 0; cursor: pointer;
        transition: color 0.18s;
    }
    .mark-all-btn:hover { color: #4338CA; }
    .notif-empty {
        text-align: center; padding: 3rem 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom overflow-hidden">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between p-4 border-bottom border-light">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark m-0" style="font-size:1rem;">Notifications</h5>
                <span class="badge-custom-indigo" style="font-size:0.7rem; padding:0.3em 0.75em;">4 Unread</span>
            </div>
            <button class="mark-all-btn" id="markAllBtn">
                <i class="bi bi-check2-all me-1"></i>Mark all as read
            </button>
        </div>

        {{-- Notification List --}}
        <div id="notifList">

            {{-- Unread --}}
            <div class="notif-item unread" data-id="1">
                <div class="notif-icon" style="background:#ECFDF5;">
                    <i class="bi bi-file-earmark-check-fill" style="color:#10B981;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title">Your resume has been reviewed.</div>
                    <p class="notif-desc">Our AI engine has completed analysis of your resume. Check your score now.</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">14 May 2024, 10:20 AM</span>
                    <div class="unread-dot"></div>
                </div>
            </div>

            {{-- Unread --}}
            <div class="notif-item unread" data-id="2">
                <div class="notif-icon" style="background:#EEF2FF;">
                    <i class="bi bi-briefcase-fill" style="color:#4F46E5;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title">You have been shortlisted for Creative IT.</div>
                    <p class="notif-desc">Congratulations! You have been shortlisted for the Laravel Developer role.</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">14 May 2024, 09:40 AM</span>
                    <div class="unread-dot"></div>
                </div>
            </div>

            {{-- Unread --}}
            <div class="notif-item unread" data-id="3">
                <div class="notif-icon" style="background:#FEF3C7;">
                    <i class="bi bi-camera-video-fill" style="color:#D97706;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title">Interview scheduled with Creative IT.</div>
                    <p class="notif-desc">Your interview is scheduled on 28 May 2024 at 10:00 AM via Google Meet.</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">13 May 2024, 03:30 PM</span>
                    <div class="unread-dot"></div>
                </div>
            </div>

            {{-- Unread --}}
            <div class="notif-item unread" data-id="4">
                <div class="notif-icon" style="background:#ECFDF5;">
                    <i class="bi bi-arrow-up-circle-fill" style="color:#10B981;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title">Your application status changed to Interview.</div>
                    <p class="notif-desc">Your application for Web Developer at Brain Station 23 moved to Interview stage.</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">09 May 2024, 11:00 AM</span>
                    <div class="unread-dot"></div>
                </div>
            </div>

            {{-- Read --}}
            <div class="notif-item" data-id="5">
                <div class="notif-icon" style="background:#F3F4F6;">
                    <i class="bi bi-bell-fill" style="color:#9CA3AF;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title" style="color:#6B7280;">New job matched your profile.</div>
                    <p class="notif-desc">A new PHP Developer role at TechSoft Ltd matches your profile. Apply now!</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">06 May 2024, 10:00 AM</span>
                </div>
            </div>

            {{-- Read --}}
            <div class="notif-item" data-id="6">
                <div class="notif-icon" style="background:#F3F4F6;">
                    <i class="bi bi-send-fill" style="color:#9CA3AF;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="notif-title" style="color:#6B7280;">Application submitted successfully.</div>
                    <p class="notif-desc">Your application for Junior PHP Developer at TechSoft Ltd was submitted.</p>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="notif-time">12 May 2024, 09:00 AM</span>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="text-center p-4 border-top border-light">
            <a href="#" class="fw-semibold text-decoration-none" style="font-size:0.85rem; color:#4F46E5;">
                View All Notifications <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('markAllBtn').addEventListener('click', function () {
        document.querySelectorAll('.notif-item.unread').forEach(item => {
            item.classList.remove('unread');
            const dot = item.querySelector('.unread-dot');
            if (dot) dot.remove();
            const title = item.querySelector('.notif-title');
            if (title) title.style.color = '#6B7280';
        });
        const badge = document.querySelector('.badge-custom-indigo');
        if (badge) badge.textContent = '0 Unread';
        this.style.opacity = '0.4';
        this.disabled = true;
    });
</script>
@endpush