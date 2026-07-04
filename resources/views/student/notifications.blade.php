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
    
    .mark-all-btn {
        font-size: 0.8rem; font-weight: 700; color: #4F46E5;
        border: none; background: none; padding: 0; cursor: pointer;
        transition: color 0.18s;
    }
    .mark-all-btn:hover { color: #4338CA; }
    
    .notif-empty {
        text-align: center; padding: 3.5rem 1rem;
    }
    .read-badge-btn {
        border: 1px solid #E5E7EB;
        background: #fff;
        color: #9CA3AF;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .read-badge-btn:hover {
        border-color: #4F46E5;
        color: #4F46E5;
        background-color: #EEF2FF;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom overflow-hidden">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between p-4 border-bottom border-light flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark m-0" style="font-size:1rem;">Notifications</h5>
                <span class="badge-custom-indigo" style="font-size:0.7rem; padding:0.3em 0.75em;">{{ $unreadCount }} Unread</span>
            </div>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="mark-all-btn">
                        <i class="bi bi-check2-all me-1"></i>Mark all as read
                    </button>
                </form>
            @endif
        </div>

        {{-- Notification List --}}
        <div id="notifList">
            @forelse($notifications as $notification)
                @php 
                    $data = $notification->data; 
                    $isUnread = $notification->unread();
                @endphp
                <div class="notif-item {{ $isUnread ? 'unread' : '' }}">
                    <div class="notif-icon" style="background: {{ $data['icon_bg'] ?? '#F3F4F6' }};">
                        <i class="bi {{ $data['icon'] ?? 'bi-bell-fill' }}" style="color: {{ $data['icon_color'] ?? '#9CA3AF' }};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="notif-title" style="{{ !$isUnread ? 'color:#6B7280;' : '' }}">
                            {{ $data['title'] ?? 'Notification' }}
                        </div>
                        <p class="notif-desc">{{ $data['message'] ?? '' }}</p>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2 ms-2">
                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                        @if($isUnread)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="read-badge-btn" title="Mark as read">
                                    <i class="bi bi-check" style="font-size: 0.95rem;"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="notif-empty">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:4.5rem;height:4.5rem;background:#F3F4F6;">
                        <i class="bi bi-bell-slash text-muted" style="font-size:1.8rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">No notifications yet</h6>
                    <p class="text-secondary mb-0" style="font-size:0.82rem;">We will notify you when something important happens.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer / Pagination --}}
        @if($notifications->hasPages())
            <div class="p-3 border-top border-light d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</div>
@endsection