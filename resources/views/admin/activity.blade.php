@extends('layouts.admin')

@section('title', 'Activity Log')
@section('header_title', 'Activity Log')
@section('header_subtitle', 'Full audit trail of actions across the platform')

@section('content')
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td style="color:var(--muted);">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        <td style="font-weight:700;">{{ $log->user_name }}</td>
                        <td>{{ $log->action }}</td>
                        <td style="color:var(--muted);">{{ $log->details ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-secondary">No activity logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
