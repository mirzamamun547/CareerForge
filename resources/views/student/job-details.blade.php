@extends('layouts.student')

@section('title', $job->title)
@section('header_title', $job->title)
@section('header_subtitle', 'Explore the full job details and apply directly.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4 p-lg-5">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <div class="badge-custom-indigo mb-2">Featured opportunity</div>
                        <h3 class="fw-bold text-dark mb-1">{{ $job->title }}</h3>
                        <p class="text-secondary mb-0">{{ $job->user->name ?? 'Company' }} • {{ $job->location }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge-custom-indigo">{{ $job->job_type }}</span>
                        <div class="mt-2 text-secondary small">{{ $job->level ?? 'Any Level' }}</div>
                    </div>
                </div>

                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Salary</div>
                            <div class="fw-bold text-dark">{{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }} BDT</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Category</div>
                            <div class="fw-bold text-dark">{{ $job->category }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#F9FAFB; border:1px solid #E5E7EB;">
                            <div class="small text-secondary">Posted</div>
                            <div class="fw-bold text-dark">{{ $job->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold text-dark">Role overview</h6>
                    <p class="text-secondary mb-0" style="line-height: 1.8;">{{ $job->description }}</p>
                </div>

                @if($job->latitude && $job->longitude)
                <div class="mt-5 pt-4 border-top border-light">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-primary"></i> Job Location</h6>
                    
                    <div class="card border border-light-subtle rounded-3 mb-3" style="background:#F9FAFB;">
                        <div class="card-body p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12 col-md-8">
                                    <div class="fw-bold text-dark mb-1">{{ $job->city ?? 'Location' }}</div>
                                    <div class="text-secondary small">{{ $job->location }}</div>
                                </div>
                                <div class="col-12 col-md-4 text-md-end">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $job->latitude }},{{ $job->longitude }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 mb-2 py-1.5" style="font-size:0.78rem;">
                                        <i class="bi bi-google"></i> Google Maps
                                    </a>
                                    <a href="https://www.openstreetmap.org/?mlat={{ $job->latitude }}&mlon={{ $job->longitude }}#map=15/{{ $job->latitude }}/{{ $job->longitude }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 py-1.5" style="font-size:0.78rem;">
                                        📍 OpenStreetMap
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="leaflet-job-map" style="height: 320px; border-radius: 0.75rem; border: 1px solid #E5E7EB; z-index: 1;"></div>
                </div>
                @endif

                <div class="mt-4 border-top border-light pt-4">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('student.jobs.apply.form', $job) }}" class="btn btn-primary-custom">Apply Now</a>
                        <form method="POST" action="{{ route('student.jobs.bookmark', $job) }}">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                            <button type="submit" class="btn {{ $bookmarked ? 'btn-warning text-white' : 'btn-outline-secondary' }} d-inline-flex align-items-center gap-2">
                                <i class="bi {{ $bookmarked ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                                {{ $bookmarked ? 'Saved' : 'Save Job' }}
                            </button>
                        </form>
                        <a href="{{ route('student.jobs') }}" class="btn btn-outline-custom">Back to jobs</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3">Company snapshot</h6>
                @php $profile = $job->user->employerProfile; @endphp
                <div class="mb-3">
                    <div class="text-secondary small">Company</div>
                    <div class="fw-bold text-dark">{{ $profile->company_name ?? ($job->user->name ?? 'Company') }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Industry</div>
                    <div class="fw-bold text-dark">{{ $profile->industry ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Address</div>
                    <div class="fw-bold text-dark">{{ $profile->company_address ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Contact</div>
                    <div class="fw-bold text-dark">{{ $profile->contact_person ?? $job->user->name }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-secondary small">Website</div>
                    <div class="fw-bold text-dark">{{ $profile->website ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($job->latitude && $job->longitude)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $job->latitude }};
        const lon = {{ $job->longitude }};
        const map = L.map('leaflet-job-map').setView([lat, lon], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([lat, lon]).addTo(map)
            .bindPopup('<strong>{{ $job->title }}</strong><br>{{ $job->city ?? $job->location }}')
            .openPopup();
    });
</script>
@endpush
@endif
@endsection