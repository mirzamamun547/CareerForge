@extends('layouts.employer')

@section('title', 'Schedule Interview')
@section('header_title', 'Schedule a New Interview')
@section('header_subtitle', 'Set up an interview with a selected applicant.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">

        <!-- Left Column: Schedule Form -->
        <div class="col-12 col-lg-7">
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark mb-4" style="font-size: 1.1rem;">Schedule a New Interview</h5>

                <form method="POST" action="{{ route('employer.schedule-interview.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Select Candidate Application</label>
                            <select name="job_application_id" id="applicationSelect" class="form-select form-control-custom @error('job_application_id') is-invalid @enderror">
                                <option value="">-- Choose Candidate --</option>
                                @foreach($applications as $app)
                                    @php
                                        $initials = collect(explode(' ', $app->student->name))->map(fn($word) => mb_substr($word, 0, 1))->take(2)->join('');
                                        $selected = (old('job_application_id', $preselectedApplicationId) == $app->id) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $app->id }}" 
                                            {{ $selected }}
                                            data-name="{{ $app->student->name }}"
                                            data-email="{{ $app->student->email }}"
                                            data-phone="{{ $app->student->phone ?? 'N/A' }}"
                                            data-job="{{ $app->jobListing->title }}"
                                            data-initials="{{ strtoupper($initials) }}">
                                        {{ $app->student->name }} — {{ $app->jobListing->title }} ({{ $app->status }})
                                    </option>
                                @endforeach
                            </select>
                            @error('job_application_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Date</label>
                            <input type="date" name="date" value="{{ old('date') }}" class="form-control form-control-custom @error('date') is-invalid @enderror" min="{{ date('Y-m-d') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Time</label>
                            <input type="time" name="time" value="{{ old('time') }}" class="form-control form-control-custom @error('time') is-invalid @enderror">
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Interview Type</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeOnline" value="online" {{ old('type', 'online') === 'online' ? 'checked' : '' }} style="border-color: #4F46E5;">
                                    <label class="form-check-label fw-medium text-dark" for="typeOnline" style="font-size: 0.85rem;">Online (Google Meet, Zoom, etc.)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeOnsite" value="onsite" {{ old('type') === 'onsite' ? 'checked' : '' }} style="border-color: #4F46E5;">
                                    <label class="form-check-label fw-medium text-dark" for="typeOnsite" style="font-size: 0.85rem;">On-site</label>
                                </div>
                            </div>
                            @error('type')
                                <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;" id="locationLabel">Meeting Link</label>
                            <input type="text" name="location" id="locationInput" value="{{ old('location') }}" class="form-control form-control-custom @error('location') is-invalid @enderror" placeholder="e.g. Zoom link or video call URL">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Note for Applicant</label>
                            <textarea name="notes" class="form-control form-control-custom @error('notes') is-invalid @enderror" rows="3" placeholder="Add preparation tips or details for the candidate...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                            <i class="bi bi-calendar-check"></i>
                            Schedule Interview
                        </button>
                        <a href="{{ route('employer.interview-schedule') }}" class="btn btn-secondary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Applicant Info Preview -->
        <div class="col-12 col-lg-5">
            <div class="card card-custom p-4 text-center" id="previewPlaceholder" style="min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <i class="bi bi-person-bounding-box text-secondary bg-opacity-10 rounded-circle mb-3 p-3" style="font-size: 2.5rem; background-color: #f3f4f6;"></i>
                <h6 class="fw-bold text-dark mb-1">No Candidate Selected</h6>
                <p class="text-secondary mb-0" style="font-size: 0.85rem;">Select a candidate from the dropdown list to preview their details here.</p>
            </div>

            <div class="card card-custom p-4 d-none" id="previewCard">
                <h5 class="fw-bold text-dark mb-4" style="font-size: 1.1rem;">Applicant Info</h5>

                <div class="text-center mb-4">
                    <div id="previewAvatar" class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto" style="width: 70px; height: 70px; font-size: 1.3rem;">
                        --
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Name</span>
                        <span id="previewName" class="fw-semibold text-dark" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Applied For</span>
                        <span id="previewJob" class="fw-semibold text-dark" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Email</span>
                        <span id="previewEmail" class="fw-semibold text-dark" style="font-size: 0.9rem;">--</span>
                    </div>
                    <div>
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Phone</span>
                        <span id="previewPhone" class="fw-semibold text-dark" style="font-size: 0.9rem;">--</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('applicationSelect');
        const placeholder = document.getElementById('previewPlaceholder');
        const card = document.getElementById('previewCard');
        
        const avatar = document.getElementById('previewAvatar');
        const name = document.getElementById('previewName');
        const job = document.getElementById('previewJob');
        const email = document.getElementById('previewEmail');
        const phone = document.getElementById('previewPhone');

        const typeOnline = document.getElementById('typeOnline');
        const typeOnsite = document.getElementById('typeOnsite');
        const locationLabel = document.getElementById('locationLabel');
        const locationInput = document.getElementById('locationInput');

        // Dynamic candidate preview
        function updatePreview() {
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                placeholder.classList.remove('d-none');
                card.classList.add('d-none');
            } else {
                placeholder.classList.add('d-none');
                card.classList.remove('d-none');

                avatar.textContent = selectedOption.getAttribute('data-initials');
                name.textContent = selectedOption.getAttribute('data-name');
                job.textContent = selectedOption.getAttribute('data-job');
                email.textContent = selectedOption.getAttribute('data-email');
                phone.textContent = selectedOption.getAttribute('data-phone');
            }
        }

        // Toggle location label/placeholder based on type
        function updateLocationPlaceholder() {
            if (typeOnline.checked) {
                locationLabel.textContent = 'Meeting Link';
                locationInput.placeholder = 'e.g. Zoom link or Google Meet URL';
            } else {
                locationLabel.textContent = 'Office Location / Address';
                locationInput.placeholder = 'e.g. 123 Business Rd, Suite 400, Dhaka';
            }
        }

        select.addEventListener('change', updatePreview);
        typeOnline.addEventListener('change', updateLocationPlaceholder);
        typeOnsite.addEventListener('change', updateLocationPlaceholder);

        // Run on initial load
        updatePreview();
        updateLocationPlaceholder();
    });
</script>
@endpush
@endsection
