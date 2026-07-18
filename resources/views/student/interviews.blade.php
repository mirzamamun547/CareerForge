@extends('layouts.student')

@section('title', 'Interview Schedule')
@section('header_title', 'Interview Schedule')
@section('header_subtitle', 'Manage your upcoming and past interviews.')

@push('styles')
<style>
    .interview-card {
        border: 1px solid #E5E7EB;
        border-radius: 0.85rem;
        background: #fff;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow 0.2s, transform 0.18s;
    }
    .interview-card:hover {
        box-shadow: 0 6px 24px rgba(79,70,229,0.10);
        transform: translateY(-2px);
    }
    .company-avatar {
        width: 3rem; height: 3rem;
        border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; font-weight: 800;
        flex-shrink: 0;
    }
    .meta-chip {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.75rem; color: #6B7280; font-weight: 600;
    }
    .meta-chip i { color: #9CA3AF; font-size: 0.8rem; }
    .badge-online  { background:#ECFDF5; color:#10B981; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem; }
    .badge-onsite  { background:#EEF2FF; color:#4F46E5; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem; }
    .view-detail-btn {
        font-size: 0.8rem; font-weight: 700;
        padding: 0.5rem 1.1rem;
        border-radius: 0.6rem;
        background: #4F46E5; color: #fff;
        border: none; transition: background 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .view-detail-btn:hover { background: #4338CA; color: #fff; }
    .note-banner {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 0.75rem;
        padding: 0.85rem 1.1rem;
        font-size: 0.82rem;
        color: #92400E;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0 d-flex flex-column gap-4">

    {{-- Upcoming Interviews --}}
    <div class="card card-custom p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-dark m-0" style="font-size:1rem;">
                <i class="bi bi-calendar2-week-fill me-2" style="color:#4F46E5;"></i>Upcoming Interviews
            </h5>
            <span class="badge-custom-indigo" style="font-size:0.72rem; padding:0.35em 0.85em;">{{ $upcoming->count() }} Scheduled</span>
        </div>

        <div class="d-flex flex-column gap-3">
            @if($upcoming->isEmpty())
                <div class="text-center py-5">
                    <div class="text-secondary mb-3">
                        <i class="bi bi-calendar-check" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark">No Scheduled Interviews</h6>
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">You don't have any upcoming interviews scheduled at the moment.</p>
                </div>
            @else
                @foreach($upcoming as $interview)
                    @php
                        $companyName = $interview->employer->name ?? 'Company';
                        $initials = collect(explode(' ', $companyName))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->join('');
                    @endphp
                    <div class="interview-card">
                        <div class="company-avatar bg-primary bg-opacity-10 text-primary">
                            {{ strtoupper($initials) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem;">
                                    {{ $interview->jobApplication->jobListing->title }}
                                </h6>
                                @if($interview->type === 'online')
                                    <span class="badge-online">Online</span>
                                @else
                                    <span class="badge-onsite">On-Site</span>
                                @endif
                            </div>
                            <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">
                                {{ $companyName }}
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="meta-chip"><i class="bi bi-calendar3"></i> {{ $interview->scheduled_at->format('d M Y') }}</span>
                                <span class="meta-chip"><i class="bi bi-clock"></i> {{ $interview->scheduled_at->format('h:i A') }}</span>
                                @if($interview->type === 'online')
                                    <span class="meta-chip"><i class="bi bi-camera-video"></i> Video Call</span>
                                @else
                                    <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ Str::limit($interview->location, 30) }}</span>
                                @endif
                            </div>
                        </div>
                        <button class="view-detail-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#interviewDetailsModal"
                                data-job="{{ $interview->jobApplication->jobListing->title }}"
                                data-company="{{ $companyName }}"
                                data-date="{{ $interview->scheduled_at->format('d M Y') }}"
                                data-time="{{ $interview->scheduled_at->format('h:i A') }}"
                                data-type="{{ ucfirst($interview->type) }}"
                                data-location="{{ $interview->location }}"
                                data-notes="{{ $interview->notes ?? 'No additional notes provided.' }}">
                            View Details
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Note Banner --}}
        <div class="note-banner mt-4">
            <i class="bi bi-info-circle-fill flex-shrink-0" style="color:#D97706;"></i>
            <span>Note: Please check your meeting link or locations beforehand and join on time. Good luck!</span>
        </div>
    </div>

    {{-- Past Interviews --}}
    <div class="card card-custom p-4">
        <h5 class="fw-bold text-dark mb-4" style="font-size:1rem;">
            <i class="bi bi-clock-history me-2" style="color:#9CA3AF;"></i>Past & Cancelled Interviews
        </h5>

        <div class="d-flex flex-column gap-3">
            @if($past->isEmpty())
                <div class="text-center py-4">
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">No past interview records found.</p>
                </div>
            @else
                @foreach($past as $interview)
                    @php
                        $companyName = $interview->employer->name ?? 'Company';
                        $initials = collect(explode(' ', $companyName))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->join('');
                        $isCancelled = $interview->status === 'cancelled';
                    @endphp
                    <div class="interview-card" style="opacity: 0.85; {{ $isCancelled ? 'background-color: #fcfcfc;' : '' }}">
                        <div class="company-avatar bg-secondary bg-opacity-10 text-secondary">
                            {{ strtoupper($initials) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold text-dark mb-0" style="font-size:0.92rem; {{ $isCancelled ? 'text-decoration: line-through; color: #9CA3AF !important;' : '' }}">
                                    {{ $interview->jobApplication->jobListing->title }}
                                </h6>
                                @if($isCancelled)
                                    <span class="status-badge" style="background:#FFE4E6; color:#F43F5E; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem;">Cancelled</span>
                                @else
                                    <span class="status-badge" style="background:#F3F4F6; color:#6B7280; font-size:0.7rem; font-weight:700; padding:0.28em 0.75em; border-radius:50rem;">Completed</span>
                                @endif
                            </div>
                            <div class="text-secondary fw-semibold mb-2" style="font-size:0.8rem;">
                                {{ $companyName }}
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="meta-chip"><i class="bi bi-calendar3"></i> {{ $interview->scheduled_at->format('d M Y') }}</span>
                                <span class="meta-chip"><i class="bi bi-clock"></i> {{ $interview->scheduled_at->format('h:i A') }}</span>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-light border rounded-3 fw-semibold" 
                                style="font-size: 0.75rem; padding: 0.4rem 0.9rem;"
                                data-bs-toggle="modal" 
                                data-bs-target="#interviewDetailsModal"
                                data-job="{{ $interview->jobApplication->jobListing->title }}"
                                data-company="{{ $companyName }}"
                                data-date="{{ $interview->scheduled_at->format('d M Y') }}"
                                data-time="{{ $interview->scheduled_at->format('h:i A') }}"
                                data-type="{{ ucfirst($interview->type) }}"
                                data-location="{{ $interview->location }}"
                                data-notes="{{ $interview->notes ?? 'No additional notes provided.' }}">
                            Details
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

<!-- Details Modal -->
<div class="modal fade" id="interviewDetailsModal" tabindex="-1" aria-labelledby="interviewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="interviewDetailsModalLabel">Interview Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="mb-4">
                    <h6 class="fw-bold mb-0 text-primary" id="modalJobTitle">--</h6>
                    <small class="text-secondary fw-semibold" id="modalCompany">--</small>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <span class="text-secondary d-block" style="font-size: 0.75rem; font-weight: 600;">DATE</span>
                        <span class="fw-bold text-dark" id="modalDate" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block" style="font-size: 0.75rem; font-weight: 600;">TIME</span>
                        <span class="fw-bold text-dark" id="modalTime" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block" style="font-size: 0.75rem; font-weight: 600;">TYPE</span>
                        <span class="fw-bold text-dark" id="modalType" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block" style="font-size: 0.75rem; font-weight: 600;">LOCATION / LINK</span>
                        <div id="modalLocationContainer">--</div>
                    </div>
                </div>

                <div class="bg-light p-3 rounded-3">
                    <span class="text-secondary d-block mb-1" style="font-size: 0.75rem; font-weight: 600;">NOTE FROM RECRUITER</span>
                    <p class="text-dark mb-0 style-notes" id="modalNotes" style="font-size: 0.85rem; white-space: pre-wrap;"></p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal" style="font-size: 0.85rem;">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('interviewDetailsModal');
        
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            const job = button.getAttribute('data-job');
            const company = button.getAttribute('data-company');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const type = button.getAttribute('data-type');
            const location = button.getAttribute('data-location');
            const notes = button.getAttribute('data-notes');
            
            modal.querySelector('#modalJobTitle').textContent = job;
            modal.querySelector('#modalCompany').textContent = company;
            modal.querySelector('#modalDate').textContent = date;
            modal.querySelector('#modalTime').textContent = time;
            modal.querySelector('#modalType').textContent = type;
            modal.querySelector('#modalNotes').textContent = notes;

            const locContainer = modal.querySelector('#modalLocationContainer');
            if (type.toLowerCase() === 'online') {
                locContainer.innerHTML = `<a href="${location}" target="_blank" class="text-decoration-none d-inline-flex align-items-center gap-1 fw-bold">
                    <i class="bi bi-camera-video-fill"></i> Join Interview Link
                </a>`;
            } else {
                locContainer.innerHTML = `<span class="fw-bold text-dark" style="font-size: 0.9rem;"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>${location}</span>`;
            }
        });
    });
</script>
@endpush
@endsection