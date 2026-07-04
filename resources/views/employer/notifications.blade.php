@extends('layouts.employer')

@section('title', 'Notifications')
@section('header_title', 'Notifications')
@section('header_subtitle', 'Stay updated with all activity related to your jobs and applicants.')

@push('styles')
<style>
    .notif-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        padding: 1rem;
        border-radius: 0.75rem;
        border: 1px solid #E5E7EB;
        transition: all 0.2s ease;
        position: relative;
    }
    .notif-item.unread {
        background-color: #EEF2FF;
        border-color: #E0E7FF;
    }
    .notif-item.read {
        background-color: #F9FAFB;
        border-color: #E5E7EB;
    }
    .notif-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .icon-shape {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        flex-shrink: 0;
    }
    .mark-all-link {
        text-decoration: none;
        fw-semibold: 600;
        font-size: 0.85rem;
        color: #4F46E5;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    .mark-all-link:hover {
        color: #3B32B3;
    }
    .read-btn {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9CA3AF;
        transition: all 0.2s;
    }
    .read-btn:hover {
        border-color: #4F46E5;
        color: #4F46E5;
        background-color: #EEF2FF;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">All Notifications</h5>
                <span class="badge-custom-indigo" style="font-size: 0.72rem; padding: 0.35em 0.75em;">{{ $unreadCount }} Unread</span>
            </div>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="mark-all-link">Mark all as read</button>
                </form>
            @endif
        </div>

        <!-- Notification List -->
        <div class="d-flex flex-column gap-2 mb-4">
            @forelse($notifications as $notification)
                @php 
                    $data = $notification->data;
                    $isUnread = $notification->unread();
                @endphp
                <div class="notif-item {{ $isUnread ? 'unread' : 'read' }}">
                    <div class="icon-shape" style="background-color: {{ $data['icon_bg'] ?? '#F3F4F6' }};">
                        <i class="bi {{ $data['icon'] ?? 'bi-bell-fill' }}" style="color: {{ $data['icon_color'] ?? '#9CA3AF' }};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1 text-dark" style="font-size: 0.9rem; {{ !$isUnread ? 'color:#6B7280 !important;' : '' }}">
                            {!! $data['message'] ?? ($data['title'] ?? '') !!}
                        </p>
                        <span class="text-secondary" style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    
                    @if($isUnread)
                        <div class="flex-shrink-0 d-flex align-items-center gap-2">
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="read-btn shadow-sm" title="Mark as read">
                                    <i class="bi bi-check" style="font-size: 1rem;"></i>
                                </button>
                            </form>
                            <span class="badge rounded-pill" style="background-color: #4F46E5; width: 8px; height: 8px; padding: 0; min-width: 8px;"></span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:4.5rem;height:4.5rem;background:#F3F4F6;">
                        <i class="bi bi-bell-slash text-muted" style="font-size:1.8rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">No notifications yet</h6>
                    <p class="text-secondary mb-0" style="font-size:0.82rem;">We will notify you when students apply for your jobs.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
