@extends('layouts.employer')

@section('title', 'Manage Jobs')
@section('header_title', 'Manage Jobs')
@section('header_subtitle', 'Review and update your current job listings.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4 p-lg-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 border-bottom border-light pb-4 mb-4">
            <div>
                <div class="badge-custom-indigo mb-2">Active pipeline</div>
                <h4 class="fw-bold text-dark mb-1">Manage your openings</h4>
                <p class="text-secondary mb-0">Keep listings fresh, update details, and review applicant interest.</p>
            </div>
            <a href="/employer/jobs" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> Post a new job
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="border rounded-4 p-3" style="background:#F9FAFB; border-color:#E5E7EB;">
                    <div class="text-secondary" style="font-size:0.78rem;">Open positions</div>
                    <div class="fw-bold text-dark" style="font-size:1.2rem;">{{ $jobs->count() }}</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="border rounded-4 p-3" style="background:#ECFDF5; border-color:#A7F3D0;">
                    <div class="text-success" style="font-size:0.78rem;">Active listings</div>
                    <div class="fw-bold text-dark" style="font-size:1.2rem;">{{ $jobs->where('status', 'Active')->count() }}</div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="border rounded-4 p-3" style="background:#EEF2FF; border-color:#C7D2FE;">
                    <div class="text-primary" style="font-size:0.78rem;">Needs attention</div>
                    <div class="fw-bold text-dark" style="font-size:1.2rem;">{{ $jobs->where('status', 'Inactive')->count() }}</div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @forelse($jobs as $job)
                <div class="col-12">
                    <div class="border rounded-4 p-4" style="border-color:#E5E7EB; background:#fff;">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $job->title }}</h5>
                                <p class="text-secondary mb-2" style="font-size:0.9rem;">{{ $job->category }} • {{ $job->job_type }} • {{ $job->location }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge-custom-indigo">{{ $job->level ?? 'Any Level' }}</span>
                                    <span class="{{ $job->status === 'Active' ? 'badge-custom-emerald' : 'badge-custom-rose' }}">{{ $job->status }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-outline-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editJobModal{{ $job->id }}">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>
                                <a href="{{ route('employer.applicants') }}" class="btn btn-warning-custom btn-sm">
                                    <i class="bi bi-people me-1"></i>Applicants
                                </a>
                            </div>
                        </div>
                        <div class="mt-3 text-secondary" style="font-size:0.85rem;">Posted {{ $job->created_at->format('d M Y') }} • Salary {{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }} BDT</div>
                    </div>
                </div>

                @php
                    $selectedBenefits = $job->benefits ? array_map('trim', explode(',', $job->benefits)) : [];
                @endphp
                <div class="modal fade" id="editJobModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                            <div class="modal-header border-0 bg-light p-4">
                                <h5 class="fw-bold text-dark m-0">Edit job posting</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form method="POST" action="{{ route('employer.jobs.update', $job) }}" class="edit-job-form" data-job-id="{{ $job->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-12 col-md-8">
                                            <label class="form-label fw-semibold text-dark">Job title</label>
                                            <input type="text" name="title" class="form-control form-control-custom" value="{{ $job->title }}" required>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label fw-semibold text-dark">Level</label>
                                            <select name="level" class="form-select form-control-custom">
                                                <option value="Entry Level" {{ $job->level === 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                                <option value="Mid Level" {{ $job->level === 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                                                <option value="Senior Level" {{ $job->level === 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-dark">Category</label>
                                            <input type="text" name="category" class="form-control form-control-custom" value="{{ $job->category }}" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-dark">Job type</label>
                                            <select name="job_type" class="form-select form-control-custom">
                                                <option value="Full Time" {{ $job->job_type === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="Part Time" {{ $job->job_type === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                                <option value="Remote" {{ $job->job_type === 'Remote' ? 'selected' : '' }}>Remote</option>
                                                <option value="Contract" {{ $job->job_type === 'Contract' ? 'selected' : '' }}>Contract</option>
                                                <option value="Internship" {{ $job->job_type === 'Internship' ? 'selected' : '' }}>Internship</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-dark">Location</label>
                                            <input type="text" id="location-search-{{ $job->id }}" name="location" class="form-control form-control-custom" value="{{ $job->location }}" autocomplete="off" required>
                                            <div id="location-suggestions-{{ $job->id }}"></div>
                                            <input type="hidden" name="latitude" id="latitude-{{ $job->id }}" value="{{ $job->latitude }}">
                                            <input type="hidden" name="longitude" id="longitude-{{ $job->id }}" value="{{ $job->longitude }}">
                                            <input type="hidden" name="city" id="city-{{ $job->id }}" value="{{ $job->city }}">
                                            <input type="hidden" name="country" id="country-{{ $job->id }}" value="{{ $job->country }}">
                                            <div id="selected-location-card-{{ $job->id }}" class="selected-location-card" style="display: none;"></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold text-dark">Salary range</label>
                                            <div class="row g-2">
                                                <div class="col"><input type="number" name="min_salary" class="form-control form-control-custom" value="{{ $job->min_salary }}" required></div>
                                                <div class="col"><input type="number" name="max_salary" class="form-control form-control-custom" value="{{ $job->max_salary }}" required></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Deadline</label>
                                            <input type="date" name="deadline" class="form-control form-control-custom" value="{{ $job->deadline ? \Illuminate\Support\Carbon::parse($job->deadline)->format('Y-m-d') : '' }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Skills</label>
                                            <input type="text" name="skills" class="form-control form-control-custom" value="{{ $job->skills ?? '' }}" placeholder="Laravel, PHP, MySQL">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Description</label>
                                            <textarea name="description" class="form-control form-control-custom" rows="4" required>{{ $job->description }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Requirements</label>
                                            <textarea name="requirements" class="form-control form-control-custom" rows="4" placeholder="List the must-have qualifications and expectations...">{{ $job->requirements ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Benefits</label>
                                            <div class="row g-2">
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="benefits[]" value="Remote" {{ in_array('Remote', $selectedBenefits, true) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-secondary">Remote</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="benefits[]" value="Flexible Hours" {{ in_array('Flexible Hours', $selectedBenefits, true) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-secondary">Flexible Hours</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="benefits[]" value="Health Insurance" {{ in_array('Health Insurance', $selectedBenefits, true) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-secondary">Health Insurance</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="benefits[]" value="Paid Leave" {{ in_array('Paid Leave', $selectedBenefits, true) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-secondary">Paid Leave</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="benefits[]" value="Training" {{ in_array('Training', $selectedBenefits, true) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-secondary">Training</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark">Status</label>
                                            <select name="status" class="form-select form-control-custom">
                                                <option value="Active" {{ $job->status === 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ $job->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-4">
                                        <button type="button" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#jobPreviewModal{{ $job->id }}">Preview Job</button>
                                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary-custom">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="jobPreviewModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                            <div class="modal-header border-0 p-4 pb-0">
                                <div>
                                    <div class="badge-custom-indigo mb-2">Live Preview</div>
                                    <h5 class="fw-bold text-dark mb-1">Job Preview</h5>
                                    <p class="text-secondary mb-0" style="font-size:0.85rem;">This shows how the listing will appear to students.</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="border rounded-4 p-4" style="background:#F9FAFB; border-color:#E5E7EB;">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                                        <div>
                                            <h4 class="fw-bold text-dark mb-1" id="previewTitle{{ $job->id }}">{{ $job->title }}</h4>
                                            <div class="text-secondary" id="previewMeta{{ $job->id }}">{{ $job->category }} • {{ $job->location }} • {{ $job->job_type }}</div>
                                        </div>
                                        <span class="badge-custom-indigo" id="previewType{{ $job->id }}">{{ $job->job_type }}</span>
                                    </div>
                                    <div class="mt-4 row g-3">
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                <div class="small text-secondary">Salary</div>
                                                <div class="fw-bold text-dark" id="previewSalary{{ $job->id }}">{{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }} BDT</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                <div class="small text-secondary">Experience</div>
                                                <div class="fw-bold text-dark" id="previewLevel{{ $job->id }}">{{ $job->level ?? 'Entry Level' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                <div class="small text-secondary">Deadline</div>
                                                <div class="fw-bold text-dark" id="previewDeadline{{ $job->id }}">{{ $job->deadline ? \Illuminate\Support\Carbon::parse($job->deadline)->format('d M Y') : 'Not set' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-dark">Description</h6>
                                        <p class="text-secondary mb-0" id="previewDescription{{ $job->id }}">{{ $job->description }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-dark">Requirements</h6>
                                        <p class="text-secondary mb-0" id="previewRequirements{{ $job->id }}">{{ $job->requirements ?? 'Your requirements will appear here.' }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-dark">Skills</h6>
                                        <div class="d-flex flex-wrap gap-2" id="previewSkills{{ $job->id }}">
                                            @if($job->skills)
                                                @foreach(explode(',', $job->skills) as $skill)
                                                    <span class="badge-custom-indigo">{{ trim($skill) }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge-custom-indigo">Laravel</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-dark">Benefits</h6>
                                        <div class="d-flex flex-wrap gap-2" id="previewBenefits{{ $job->id }}">
                                            @if($job->benefits)
                                                @foreach($selectedBenefits as $benefit)
                                                    <span class="badge-custom-emerald">{{ $benefit }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge-custom-emerald">Remote</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 border rounded-4" style="border-style:dashed; border-color:#E5E7EB;">
                        <p class="text-secondary mb-0">No jobs yet. Post your first opening to start recruiting.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('js/location.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-job-form').forEach(function (form) {
            const jobId = form.dataset.jobId;

            initLocationAutocomplete({
                searchInput: `#location-search-${jobId}`,
                suggestionsContainer: `#location-suggestions-${jobId}`,
                latInput: `#latitude-${jobId}`,
                lonInput: `#longitude-${jobId}`,
                cityInput: `#city-${jobId}`,
                countryInput: `#country-${jobId}`,
                selectedCard: `#selected-location-card-${jobId}`
            });
            const titleInput = form.querySelector('input[name="title"]');
            const categoryInput = form.querySelector('input[name="category"]');
            const locationInput = form.querySelector('input[name="location"]');
            const levelInput = form.querySelector('select[name="level"]');
            const minInput = form.querySelector('input[name="min_salary"]');
            const maxInput = form.querySelector('input[name="max_salary"]');
            const deadlineInput = form.querySelector('input[name="deadline"]');
            const skillsInput = form.querySelector('input[name="skills"]');
            const descriptionInput = form.querySelector('textarea[name="description"]');
            const requirementsInput = form.querySelector('textarea[name="requirements"]');
            const typeInput = form.querySelector('select[name="job_type"]');
            const previewTitle = document.getElementById(`previewTitle${jobId}`);
            const previewMeta = document.getElementById(`previewMeta${jobId}`);
            const previewType = document.getElementById(`previewType${jobId}`);
            const previewSalary = document.getElementById(`previewSalary${jobId}`);
            const previewLevel = document.getElementById(`previewLevel${jobId}`);
            const previewDeadline = document.getElementById(`previewDeadline${jobId}`);
            const previewDescription = document.getElementById(`previewDescription${jobId}`);
            const previewRequirements = document.getElementById(`previewRequirements${jobId}`);
            const previewSkills = document.getElementById(`previewSkills${jobId}`);
            const previewBenefits = document.getElementById(`previewBenefits${jobId}`);

            function updatePreview() {
                const title = titleInput?.value || 'Your job title will appear here';
                const category = categoryInput?.value || 'Category';
                const location = locationInput?.value || 'Location';
                const level = levelInput?.value || 'Entry Level';
                const min = minInput?.value || '0';
                const max = maxInput?.value || '0';
                const deadline = deadlineInput?.value ? new Date(deadlineInput.value).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Not set';
                const description = descriptionInput?.value || 'Your job description will appear here.';
                const requirements = requirementsInput?.value || 'Your requirements will appear here.';
                const skills = (skillsInput?.value || 'Laravel').split(',').map(s => s.trim()).filter(Boolean);
                const selectedType = typeInput?.value || 'Full Time';
                const checkedBenefits = Array.from(form.querySelectorAll('input[name="benefits[]"]:checked')).map(cb => cb.value);

                if (previewTitle) previewTitle.textContent = title;
                if (previewMeta) previewMeta.textContent = `${category} • ${location} • ${selectedType}`;
                if (previewType) previewType.textContent = selectedType;
                if (previewSalary) previewSalary.textContent = `${Number(min).toLocaleString()} - ${Number(max).toLocaleString()} BDT`;
                if (previewLevel) previewLevel.textContent = level;
                if (previewDeadline) previewDeadline.textContent = deadline;
                if (previewDescription) previewDescription.textContent = description;
                if (previewRequirements) previewRequirements.textContent = requirements;
                if (previewSkills) {
                    previewSkills.innerHTML = skills.length ? skills.map(skill => `<span class="badge-custom-indigo">${skill}</span>`).join('') : '<span class="badge-custom-indigo">Laravel</span>';
                }
                if (previewBenefits) {
                    previewBenefits.innerHTML = checkedBenefits.length ? checkedBenefits.map(benefit => `<span class="badge-custom-emerald">${benefit}</span>`).join('') : '<span class="badge-custom-emerald">Remote</span>';
                }
            }

            [titleInput, categoryInput, locationInput, levelInput, minInput, maxInput, deadlineInput, skillsInput, descriptionInput, requirementsInput, typeInput].forEach(function (field) {
                field?.addEventListener('input', updatePreview);
                field?.addEventListener('change', updatePreview);
            });

            form.querySelectorAll('input[name="benefits[]"]').forEach(function (checkbox) {
                checkbox.addEventListener('change', updatePreview);
            });

            const previewButton = form.querySelector('button[data-bs-target]');
            previewButton?.addEventListener('click', updatePreview);
        });
    });
</script>
@endpush

@endsection
