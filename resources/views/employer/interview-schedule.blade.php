@extends('layouts.employer')

@section('title', 'Interview Schedule')
@section('header_title', 'Interview Schedule')
@section('header_subtitle', 'View and manage all scheduled interviews.')

@section('content')
<div class="container-fluid p-0">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 0.5rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 0.5rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- Upcoming Interviews Card -->
        <div class="col-12">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">Upcoming Interviews</h5>
                        <p class="text-secondary m-0 mt-1" style="font-size: 0.8rem;">Interviews scheduled with candidates in the future.</p>
                    </div>
                    <a href="{{ route('employer.schedule-interview') }}" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                        <i class="bi bi-plus-lg"></i>
                        Schedule New Interview
                    </a>
                </div>

                @if($upcoming->isEmpty())
                    <div class="text-center py-5">
                        <div class="text-secondary mb-3">
                            <i class="bi bi-calendar-event" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark">No Upcoming Interviews</h6>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">You haven't scheduled any upcoming interviews yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Applicant</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Job Title</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Date</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Time</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Type</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Location/Link</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Status</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcoming as $interview)
                                    @php
                                        $initials = collect(explode(' ', $interview->student->name))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->join('');
                                    @endphp
                                    <tr>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem; min-width: 36px;">
                                                    {{ strtoupper($initials) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">{{ $interview->student->name }}</span>
                                                    <span class="text-secondary" style="font-size: 0.75rem;">{{ $interview->student->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">
                                            {{ $interview->jobApplication->jobListing->title }}
                                        </td>
                                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">
                                            {{ $interview->scheduled_at->format('d M Y') }}
                                        </td>
                                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">
                                            {{ $interview->scheduled_at->format('h:i A') }}
                                        </td>
                                        <td class="py-3">
                                            @if($interview->type === 'online')
                                                <span class="badge-custom-indigo">Online</span>
                                            @else
                                                <span class="badge-custom-amber">On-site</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-secondary" style="font-size: 0.85rem; max-width: 200px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            @if($interview->type === 'online')
                                                <a href="{{ $interview->location }}" target="_blank" class="text-decoration-none d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-camera-video"></i>
                                                    Join Link
                                                </a>
                                            @else
                                                <span title="{{ $interview->location }}"><i class="bi bi-geo-alt me-1"></i>{{ $interview->location }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <span class="badge-custom-emerald">Scheduled</span>
                                        </td>
                                        <td class="py-3">
                                            <form action="{{ route('employer.interviews.cancel', $interview) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this interview?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light border rounded-3 text-danger" title="Cancel Interview">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Past & Cancelled Interviews Card -->
        <div class="col-12">
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark mb-2" style="font-size: 1.1rem;">Past & Cancelled Interviews</h5>
                <p class="text-secondary mb-4" style="font-size: 0.8rem;">Record of previous interviews or cancelled scheduling.</p>

                @if($past->isEmpty())
                    <div class="text-center py-4">
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">No past or cancelled interviews found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle" style="opacity: 0.85;">
                            <thead>
                                <tr>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Applicant</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Job Title</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Date & Time</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Type</th>
                                    <th class="text-secondary fw-semibold" style="font-size: 0.85rem; border-bottom: 1px solid #E5E7EB;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($past as $interview)
                                    @php
                                        $initials = collect(explode(' ', $interview->student->name))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->join('');
                                        $isCancelled = $interview->status === 'cancelled';
                                    @endphp
                                    <tr style="{{ $isCancelled ? 'text-decoration: line-through; opacity: 0.6;' : '' }}">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem; min-width: 36px;">
                                                    {{ strtoupper($initials) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">{{ $interview->student->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-dark fw-medium" style="font-size: 0.85rem;">
                                            {{ $interview->jobApplication->jobListing->title }}
                                        </td>
                                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">
                                            {{ $interview->scheduled_at->format('d M Y, h:i A') }}
                                        </td>
                                        <td class="py-3 text-secondary" style="font-size: 0.85rem;">
                                            {{ ucfirst($interview->type) }}
                                        </td>
                                        <td class="py-3">
                                            @if($isCancelled)
                                                <span class="badge-custom-rose">Cancelled</span>
                                            @elseif($interview->status === 'completed')
                                                <span class="badge-custom-emerald">Completed</span>
                                            @else
                                                <span class="badge-custom-indigo">Past</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
