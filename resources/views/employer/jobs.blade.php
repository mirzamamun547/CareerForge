@extends('layouts.employer')

@section('title', 'Post a Job')
@section('header_title', 'Post a New Job')
@section('header_subtitle', 'Create a new career listing for prospective applicants.')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card card-custom p-4 p-lg-5">
                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
                    <div>
                        <div class="badge-custom-indigo mb-2">Job Listing Builder</div>
                        <h4 class="fw-bold text-dark mb-1">Post New Job</h4>
                        <p class="text-secondary mb-0">Fill in the details below to publish a polished role listing.</p>
                    </div>
                    <a href="/employer/manage-jobs" class="btn btn-outline-custom btn-sm">Manage Jobs</a>
                </div>

                <form method="POST" action="{{ route('employer.jobs.store') }}">
                    @csrf

                    <div class="border rounded-4 p-4 mb-4" style="border-color:#E5E7EB; background:#FCFCFD;">
                        <h5 class="fw-bold text-dark mb-3">Job Details</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Job Title *</label>
                                <input type="text" name="title" class="form-control form-control-custom" placeholder="e.g. Senior Laravel Developer" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Category *</label>
                                <select name="category" class="form-select form-control-custom">
                                    <option>Software Development</option>
                                    <option>Design</option>
                                    <option>Marketing</option>
                                    <option>Operations</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Job Type *</label>
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="job_type" value="Full Time" checked>
                                        <label class="form-check-label text-secondary">Full Time</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="job_type" value="Part Time">
                                        <label class="form-check-label text-secondary">Part Time</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="job_type" value="Internship">
                                        <label class="form-check-label text-secondary">Internship</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="job_type" value="Remote">
                                        <label class="form-check-label text-secondary">Remote</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Location *</label>
                                <input type="text" id="location-search" name="location" class="form-control form-control-custom" placeholder="Search location... (e.g. Banani, Dhaka)" autocomplete="off" required>
                                <div id="location-suggestions"></div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <input type="hidden" name="city" id="city">
                                <input type="hidden" name="country" id="country">
                                <div id="selected-location-card" class="selected-location-card" style="display: none;"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Experience Required</label>
                                <select name="level" class="form-select form-control-custom">
                                    <option value="Entry Level">0-1 Years</option>
                                    <option value="Mid Level">1-3 Years</option>
                                    <option value="Senior Level">3+ Years</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Minimum Salary</label>
                                <input type="number" name="min_salary" class="form-control form-control-custom" placeholder="30000" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-dark">Maximum Salary</label>
                                <input type="number" name="max_salary" class="form-control form-control-custom" placeholder="50000" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Deadline</label>
                                <input type="date" name="deadline" class="form-control form-control-custom">
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-4 p-4 mb-4" style="border-color:#E5E7EB; background:#FCFCFD;">
                        <h5 class="fw-bold text-dark mb-3">Required Skills</h5>
                        <div id="skillChips" class="d-flex flex-wrap gap-2 mb-3"></div>
                        <input type="text" id="skillTagInput" list="skillSuggestionsList" class="form-control form-control-custom"
                               placeholder="Type a skill and press Enter (e.g. React, Docker, AWS)...">
                        <datalist id="skillSuggestionsList">
                            @foreach(($skillSuggestions ?? []) as $suggestion)
                                <option value="{{ $suggestion }}">
                            @endforeach
                        </datalist>
                        <input type="hidden" name="skills" id="skillsHiddenInput" required>
                        <div class="form-text mt-2" style="font-size:0.75rem;">
                            Press <strong>Enter</strong> or <strong>,</strong> to add a skill. Pick an existing one from the suggestions or type a new one.
                        </div>
                    </div>

                    <script>
                    (function () {
                        const chipContainer = document.getElementById('skillChips');
                        const tagInput = document.getElementById('skillTagInput');
                        const hiddenInput = document.getElementById('skillsHiddenInput');
                        let skills = [];

                        function render() {
                            chipContainer.innerHTML = skills.map((skill, i) => `
                                <span class="badge-custom-indigo d-inline-flex align-items-center gap-2">
                                    ${skill}
                                    <button type="button" data-index="${i}" class="skill-chip-remove btn-close btn-close-sm" style="font-size:0.55rem;"></button>
                                </span>
                            `).join('');
                            hiddenInput.value = skills.join(', ');
                            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));

                            chipContainer.querySelectorAll('.skill-chip-remove').forEach(btn => {
                                btn.addEventListener('click', () => {
                                    skills.splice(parseInt(btn.dataset.index), 1);
                                    render();
                                });
                            });
                        }

                        function addSkill(raw) {
                            const name = raw.trim().replace(/,$/, '');
                            if (!name) return;
                            const exists = skills.some(s => s.toLowerCase() === name.toLowerCase());
                            if (!exists) {
                                skills.push(name);
                                render();
                            }
                            tagInput.value = '';
                        }

                        tagInput.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ',') {
                                e.preventDefault();
                                addSkill(tagInput.value);
                            }
                        });
                        tagInput.addEventListener('blur', () => {
                            if (tagInput.value.trim()) addSkill(tagInput.value);
                        });
                    })();
                    </script>

                    <div class="border rounded-4 p-4 mb-4" style="border-color:#E5E7EB; background:#FCFCFD;">
                        <h5 class="fw-bold text-dark mb-3">Job Description</h5>
                        <textarea name="description" class="form-control form-control-custom" rows="5" placeholder="Describe the role, responsibilities, and why this opportunity is exciting..." required></textarea>
                    </div>

                    <div class="border rounded-4 p-4 mb-4" style="border-color:#E5E7EB; background:#FCFCFD;">
                        <h5 class="fw-bold text-dark mb-3">Requirements</h5>
                        <textarea name="requirements" class="form-control form-control-custom" rows="4" placeholder="List the must-have qualifications and expectations..." required></textarea>
                    </div>

                    <div class="border rounded-4 p-4 mb-4" style="border-color:#E5E7EB; background:#FCFCFD;">
                        <h5 class="fw-bold text-dark mb-3">Benefits</h5>
                        <div class="row g-2">
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="benefits[]" value="Remote" checked>
                                    <label class="form-check-label text-secondary">Remote</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="benefits[]" value="Flexible Hours" checked>
                                    <label class="form-check-label text-secondary">Flexible Hours</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="benefits[]" value="Health Insurance">
                                    <label class="form-check-label text-secondary">Health Insurance</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="benefits[]" value="Paid Leave">
                                    <label class="form-check-label text-secondary">Paid Leave</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="benefits[]" value="Training">
                                    <label class="form-check-label text-secondary">Training</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="Active">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">
                        <button type="button" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#jobPreviewModal">Preview Job</button>
                        <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
                            <i class="bi bi-send-fill"></i> Publish Job
                        </button>
                    </div>

                    <div class="modal fade" id="jobPreviewModal" tabindex="-1" aria-labelledby="jobPreviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                                <div class="modal-header border-0 p-4 pb-0">
                                    <div>
                                        <div class="badge-custom-indigo mb-2">Live Preview</div>
                                        <h5 class="fw-bold text-dark mb-1" id="jobPreviewModalLabel">Job Preview</h5>
                                        <p class="text-secondary mb-0" style="font-size:0.85rem;">This shows how the listing will appear to students.</p>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="border rounded-4 p-4" style="background:#F9FAFB; border-color:#E5E7EB;">
                                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                                            <div>
                                                <h4 class="fw-bold text-dark mb-1" id="previewTitle">Your job title will appear here</h4>
                                                <div class="text-secondary" id="previewMeta">Category • Location • Full Time</div>
                                            </div>
                                            <span class="badge-custom-indigo" id="previewType">Full Time</span>
                                        </div>
                                        <div class="mt-4 row g-3">
                                            <div class="col-md-4">
                                                <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                    <div class="small text-secondary">Salary</div>
                                                    <div class="fw-bold text-dark" id="previewSalary">0 - 0 BDT</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                    <div class="small text-secondary">Experience</div>
                                                    <div class="fw-bold text-dark" id="previewLevel">Entry Level</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
                                                    <div class="small text-secondary">Deadline</div>
                                                    <div class="fw-bold text-dark" id="previewDeadline">Not set</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h6 class="fw-bold text-dark">Description</h6>
                                            <p class="text-secondary mb-0" id="previewDescription">Your job description will appear here.</p>
                                        </div>
                                        <div class="mt-4">
                                            <h6 class="fw-bold text-dark">Requirements</h6>
                                            <p class="text-secondary mb-0" id="previewRequirements">Your requirements will appear here.</p>
                                        </div>
                                        <div class="mt-4">
                                            <h6 class="fw-bold text-dark">Skills</h6>
                                            <div class="d-flex flex-wrap gap-2" id="previewSkills">
                                                <span class="badge-custom-indigo">Laravel</span>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h6 class="fw-bold text-dark">Benefits</h6>
                                            <div class="d-flex flex-wrap gap-2" id="previewBenefits">
                                                <span class="badge-custom-emerald">Remote</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-custom p-4 sticky-top" style="top: 1.5rem;">
                <div class="badge-custom-amber mb-3">Live Preview</div>
                <h5 class="fw-bold text-dark">Preview</h5>
                <div class="border rounded-4 p-3 mt-3" style="background:#F9FAFB; border-color:#E5E7EB;">
                    <div class="text-secondary" style="font-size:0.78rem;">Job Preview</div>
                    <div class="fw-bold text-dark mt-1" id="previewSidebarTitle">Your job title will appear here</div>
                    <div class="text-secondary mt-2" style="font-size:0.85rem;" id="previewSidebarMeta">Category • Location • Full Time</div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('js/location.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initLocationAutocomplete({
            searchInput: '#location-search',
            suggestionsContainer: '#location-suggestions',
            latInput: '#latitude',
            lonInput: '#longitude',
            cityInput: '#city',
            countryInput: '#country',
            selectedCard: '#selected-location-card'
        });
    });

    const previewModalButton = document.querySelector('[data-bs-target="#jobPreviewModal"]');
    const titleInput = document.querySelector('input[name="title"]');
    const categoryInput = document.querySelector('select[name="category"]');
    const locationInput = document.querySelector('input[name="location"]');
    const levelInput = document.querySelector('select[name="level"]');
    const minInput = document.querySelector('input[name="min_salary"]');
    const maxInput = document.querySelector('input[name="max_salary"]');
    const deadlineInput = document.querySelector('input[name="deadline"]');
    const skillsInput = document.querySelector('input[name="skills"]');
    const descriptionInput = document.querySelector('textarea[name="description"]');
    const requirementsInput = document.querySelector('textarea[name="requirements"]');
    const previewTitle = document.getElementById('previewTitle');
    const previewMeta = document.getElementById('previewMeta');
    const previewType = document.getElementById('previewType');
    const previewSidebarTitle = document.getElementById('previewSidebarTitle');
    const previewSidebarMeta = document.getElementById('previewSidebarMeta');
    const previewSalary = document.getElementById('previewSalary');
    const previewLevel = document.getElementById('previewLevel');
    const previewDeadline = document.getElementById('previewDeadline');
    const previewDescription = document.getElementById('previewDescription');
    const previewRequirements = document.getElementById('previewRequirements');
    const previewSkills = document.getElementById('previewSkills');
    const previewBenefits = document.getElementById('previewBenefits');

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
        const selectedType = document.querySelector('input[name="job_type"]:checked')?.value || 'Full Time';

        if (previewTitle) previewTitle.textContent = title;
        if (previewMeta) previewMeta.textContent = `${category} • ${location} • ${selectedType}`;
        if (previewType) previewType.textContent = selectedType;
        if (previewSidebarTitle) previewSidebarTitle.textContent = title;
        if (previewSidebarMeta) previewSidebarMeta.textContent = `${category} • ${location} • ${selectedType}`;
        if (previewSalary) previewSalary.textContent = `${Number(min).toLocaleString()} - ${Number(max).toLocaleString()} BDT`;
        if (previewLevel) previewLevel.textContent = level;
        if (previewDeadline) previewDeadline.textContent = deadline;
        if (previewDescription) previewDescription.textContent = description;
        if (previewRequirements) previewRequirements.textContent = requirements;
        if (previewSkills) {
            previewSkills.innerHTML = skills.length ? skills.map(skill => `<span class="badge-custom-indigo">${skill}</span>`).join('') : '<span class="badge-custom-indigo">Laravel</span>';
        }
        if (previewBenefits) {
            const checkedBenefits = Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
            previewBenefits.innerHTML = checkedBenefits.length ? checkedBenefits.map(benefit => `<span class="badge-custom-emerald">${benefit}</span>`).join('') : '<span class="badge-custom-emerald">Remote</span>';
        }
    }

    [titleInput, categoryInput, locationInput, levelInput, minInput, maxInput, deadlineInput, skillsInput, descriptionInput, requirementsInput].forEach(input => {
        input?.addEventListener('input', updatePreview);
        input?.addEventListener('change', updatePreview);
    });

    document.querySelectorAll('input[name="job_type"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', updatePreview);
    });

    if (previewModalButton) {
        previewModalButton.addEventListener('click', updatePreview);
    }
</script>
@endpush

@endsection