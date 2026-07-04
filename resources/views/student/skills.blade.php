@extends('layouts.student')

@section('title', 'My Skills')
@section('header_title', 'My Skills')
@section('header_subtitle', 'Track and manage your professional skills.')

@section('header_actions')
<button class="btn btn-primary-custom d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addSkillModal"
    style="font-size:0.85rem; padding:0.55rem 1.25rem;">
    <i class="bi bi-plus-lg"></i> Add Skill
</button>
@endsection

@push('styles')
<style>
    .skill-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 1rem;
        border-radius: 0.75rem;
        transition: background 0.18s;
    }
    .skill-row:hover { background: #F9FAFB; }
    .skill-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: #2D3142;
        min-width: 90px;
    }
    .skill-level-label {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.28em 0.75em;
        border-radius: 50rem;
        min-width: 80px;
        text-align: center;
    }
    .level-beginner    { background: #FEF3C7; color: #D97706; }
    .level-intermediate{ background: #DBEAFE; color: #2563EB; }
    .level-advanced    { background: #EEF2FF; color: #4F46E5; }
    .level-expert      { background: #ECFDF5; color: #10B981; }
    .skill-progress-wrap {
        flex: 1;
        background: #E5E7EB;
        border-radius: 50rem;
        height: 7px;
        overflow: hidden;
    }
    .skill-progress-bar {
        height: 100%;
        border-radius: 50rem;
        background: linear-gradient(90deg, #6366F1, #4F46E5);
        transition: width 1s cubic-bezier(.4,0,.2,1);
    }
    .skill-pct {
        font-size: 0.8rem;
        font-weight: 700;
        color: #4F46E5;
        min-width: 36px;
        text-align: right;
    }
    .skill-actions .btn-icon {
        width: 2rem; height: 2rem;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        border: 1.5px solid #E5E7EB;
        background: #fff;
        color: #6B7280;
        transition: all 0.18s;
    }
    .skill-actions .btn-icon:hover { border-color: #4F46E5; color: #4F46E5; background: #EEF2FF; }
    .skill-actions .btn-icon.danger:hover { border-color: #F43F5E; color: #F43F5E; background: #FFF1F2; }
    .skills-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #F3F4F6;
        margin-bottom: 0.5rem;
    }
    .skills-header-col {
        font-size: 0.72rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .summary-card {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 1rem;
        color: #fff;
        padding: 1.4rem 1.5rem;
    }
    .summary-card h2 { font-size: 2.2rem; font-weight: 800; margin: 0; }
    .summary-card p  { margin: 0; font-size: 0.82rem; opacity: 0.82; }
    .tip-card {
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 0.75rem;
        padding: 1rem 1.1rem;
        font-size: 0.82rem;
        color: #4B5563;
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            @if(session('status') == 'skill-added')
                Skill added successfully!
            @elseif(session('status') == 'skill-updated')
                Skill updated successfully!
            @elseif(session('status') == 'skill-deleted')
                Skill removed successfully!
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Error!</strong> Please check the form fields.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Skills List (Main) --}}
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4">
                <div class="skills-header">
                    <h5 class="fw-bold text-dark m-0" style="font-size:1rem;">All Skills</h5>
                    <span class="badge-custom-indigo" style="font-size:0.72rem; padding:0.35em 0.8em;">{{ $counts['total'] }} Skills</span>
                </div>

                {{-- Table Header --}}
                <div class="d-flex gap-3 px-3 py-1 mt-1 mb-1">
                    <div class="skills-header-col" style="min-width:90px;">Skill</div>
                    <div class="skills-header-col" style="min-width:85px;">Level</div>
                    <div class="skills-header-col flex-grow-1">Proficiency</div>
                    <div class="skills-header-col" style="min-width:36px;">%</div>
                    <div class="skills-header-col" style="min-width:60px;">Actions</div>
                </div>

                {{-- Skills --}}
                <div class="d-flex flex-column" id="skillsList">
                    @forelse($skills as $skill)
                        <div class="skill-row" data-id="{{ $skill->id }}" data-name="{{ $skill->name }}" data-level="{{ $skill->level }}" data-proficiency="{{ $skill->proficiency }}">
                            <div class="skill-name">{{ $skill->name }}</div>
                            <div>
                                <span class="skill-level-label level-{{ strtolower($skill->level) }}">
                                    {{ $skill->level }}
                                </span>
                            </div>
                            <div class="skill-progress-wrap">
                                <div class="skill-progress-bar" style="width: {{ $skill->proficiency }}%; @if($skill->level === 'Expert') background: linear-gradient(90deg, #10B981, #059669); @endif"></div>
                            </div>
                            <div class="skill-pct" @if($skill->level === 'Expert') style="color:#10B981;" @endif>{{ $skill->proficiency }}%</div>
                            <div class="skill-actions d-flex gap-1">
                                <button class="btn-icon edit-skill-btn" title="Edit"><i class="bi bi-pencil"></i></button>
                                <form action="{{ route('student.skills.destroy', $skill) }}" method="POST" class="d-inline delete-skill-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-secondary">
                            <i class="bi bi-lightning-charge-fill display-6 text-muted mb-3 d-block"></i>
                            <p class="mb-0">No skills added yet. Add your skills to build your profile!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar: Summary + Tip --}}
        <div class="col-12 col-lg-4 d-flex flex-column gap-4">

            {{-- Summary Card --}}
            <div class="summary-card">
                <p class="mb-2" style="font-size:0.75rem; opacity:0.8; text-transform:uppercase; letter-spacing:0.07em;">Skills Overview</p>
                <h2>{{ $counts['total'] }}</h2>
                <p>Total Skills Added</p>
                <hr style="border-color:rgba(255,255,255,0.25); margin: 1rem 0 0.75rem;">
                <div class="d-flex justify-content-between">
                    <div class="text-center">
                        <div style="font-size:1.25rem; font-weight:800;">{{ $counts['expert'] }}</div>
                        <div style="font-size:0.7rem; opacity:0.75;">Expert</div>
                    </div>
                    <div class="text-center">
                        <div style="font-size:1.25rem; font-weight:800;">{{ $counts['advanced'] }}</div>
                        <div style="font-size:0.7rem; opacity:0.75;">Advanced</div>
                    </div>
                    <div class="text-center">
                        <div style="font-size:1.25rem; font-weight:800;">{{ $counts['intermediate'] }}</div>
                        <div style="font-size:0.7rem; opacity:0.75;">Intermed.</div>
                    </div>
                    <div class="text-center">
                        <div style="font-size:1.25rem; font-weight:800;">{{ $counts['beginner'] }}</div>
                        <div style="font-size:0.7rem; opacity:0.75;">Beginner</div>
                    </div>
                </div>
            </div>

            {{-- Tip Card --}}
            <div class="card card-custom p-4">
                <h6 class="fw-bold text-dark mb-3" style="font-size:0.9rem;">
                    <i class="bi bi-lightbulb-fill me-2" style="color:#D97706;"></i>Tips for You
                </h6>
                <div class="d-flex flex-column gap-2">
                    <div class="tip-card">
                        <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" style="color:#10B981;"></i>
                        <span>Add more project-based skills to stand out to employers.</span>
                    </div>
                    <div class="tip-card">
                        <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" style="color:#10B981;"></i>
                        <span>Consider adding Git, Docker, or Vue.js to boost your profile.</span>
                    </div>
                    <div class="tip-card">
                        <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" style="color:#4F46E5;"></i>
                        <span>Keep proficiency levels honest — employers verify them.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Skill Modal --}}
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('student.skills.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark" id="addSkillModalLabel" style="font-size:1rem;">
                        <i class="bi bi-plus-circle me-2" style="color:#4F46E5;"></i>Add New Skill
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size:0.85rem;">Skill Name</label>
                        <input type="text" class="form-control-custom form-control @error('name') is-invalid @enderror" name="name" placeholder="e.g. Vue.js, Docker, Git..." required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size:0.85rem;">Level</label>
                        <select class="form-control-custom form-control" name="level" required>
                            <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ old('level') == 'Advanced' || !old('level') ? 'selected' : '' }}>Advanced</option>
                            <option value="Expert" {{ old('level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark d-flex justify-content-between" style="font-size:0.85rem;">
                            Proficiency <span id="addPctLabel" class="text-primary fw-bold">70%</span>
                        </label>
                        <input type="range" class="form-range" min="10" max="100" step="5" value="{{ old('proficiency', 70) }}" name="proficiency" id="addProficiencyRange">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 gap-2">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-plus-lg me-1"></i>Add Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Skill Modal --}}
<div class="modal fade" id="editSkillModal" tabindex="-1" aria-labelledby="editSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form id="editSkillForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark" id="editSkillModalLabel" style="font-size:1rem;">
                        <i class="bi bi-pencil-square me-2" style="color:#4F46E5;"></i>Edit Skill
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size:0.85rem;">Skill Name</label>
                        <input type="text" class="form-control-custom form-control" name="name" id="editSkillName" placeholder="e.g. Vue.js, Docker, Git..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size:0.85rem;">Level</label>
                        <select class="form-control-custom form-control" name="level" id="editSkillLevel" required>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark d-flex justify-content-between" style="font-size:0.85rem;">
                            Proficiency <span id="editPctLabel" class="text-primary fw-bold">70%</span>
                        </label>
                        <input type="range" class="form-range" min="10" max="100" step="5" name="proficiency" id="editProficiencyRange">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 gap-2">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Range sliders live update
    const addRange = document.getElementById('addProficiencyRange');
    const addPctLabel = document.getElementById('addPctLabel');
    if (addRange && addPctLabel) {
        addRange.addEventListener('input', () => { addPctLabel.textContent = addRange.value + '%'; });
    }

    const editRange = document.getElementById('editProficiencyRange');
    const editPctLabel = document.getElementById('editPctLabel');
    if (editRange && editPctLabel) {
        editRange.addEventListener('input', () => { editPctLabel.textContent = editRange.value + '%'; });
    }

    // Handle Edit Skill Modal load
    document.querySelectorAll('.edit-skill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('.skill-row');
            const id = row.dataset.id;
            const name = row.dataset.name;
            const level = row.dataset.level;
            const proficiency = row.dataset.proficiency;

            // Prefill edit form
            const form = document.getElementById('editSkillForm');
            form.action = `/student/skills/${id}`;

            document.getElementById('editSkillName').value = name;
            document.getElementById('editSkillLevel').value = level;
            document.getElementById('editProficiencyRange').value = proficiency;
            document.getElementById('editPctLabel').textContent = proficiency + '%';

            // Open edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editSkillModal'));
            editModal.show();
        });
    });

    // Delete skill confirmations
    document.querySelectorAll('.delete-skill-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to remove this skill from your profile?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush