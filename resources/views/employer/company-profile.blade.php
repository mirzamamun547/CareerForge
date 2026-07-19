@extends('layouts.employer')

@section('title', 'Company Profile')
@section('header_title', 'Company Profile')
@section('header_subtitle', 'Manage your company information visible to applicants.')

@section('content')
<div class="container-fluid p-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #ECFDF5; color: #065F46;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Whoops! Please fix the errors below:</strong>
            <ul class="mb-0 mt-2" style="font-size: 0.85rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-custom p-4">

        <!-- ===================== VIEW MODE ===================== -->
        <div id="viewMode">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; overflow: hidden;">
                        @if($profile->company_logo)
                            <img src="{{ asset('storage/' . $profile->company_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-building text-secondary" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $profile->company_name ?: 'Your Company' }}</h5>
                        <span class="text-secondary" style="font-size: 0.8rem;">{{ $profile->industry ?: 'Set your company details' }}</span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;" onclick="showEditMode()">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Company Name</p>
                    <p class="fw-semibold text-dark mb-0">{{ $profile->company_name ?: '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Company Email</p>
                    <p class="fw-semibold text-dark mb-0">{{ $profile->company_email ?: '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Contact Person</p>
                    <p class="fw-semibold text-dark mb-0">{{ $profile->contact_person ?: '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Phone</p>
                    <p class="fw-semibold text-dark mb-0">{{ $user->phone ?: '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Website</p>
                    <p class="fw-semibold text-dark mb-0">
                        @if($profile->website)
                            <a href="{{ $profile->website }}" target="_blank" class="text-primary text-decoration-none">{{ $profile->website }}</a>
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Industry</p>
                    <p class="fw-semibold text-dark mb-0">{{ $profile->industry ?: '—' }}</p>
                </div>
                <div class="col-12">
                    <p class="text-secondary mb-1" style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Company Address</p>
                    <p class="fw-semibold text-dark mb-0">{{ $profile->company_address ?: '—' }}</p>
                </div>
            </div>
        </div>

        <!-- ===================== EDIT MODE ===================== -->
        <div id="editMode" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px; overflow: hidden;" id="logoPreviewContainer">
                        @if($profile->company_logo)
                            <img id="logoPreview" src="{{ asset('storage/' . $profile->company_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i id="logoPlaceholderIcon" class="bi bi-building text-secondary" style="font-size: 1.5rem;"></i>
                            <img id="logoPreview" src="" alt="" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Edit Company Profile</h5>
                        <span class="text-secondary" style="font-size: 0.8rem;">Update your company details</span>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;" onclick="showViewMode()">
                    <i class="bi bi-x-lg"></i>
                    Cancel
                </button>
            </div>

            <form action="{{ route('employer.company-profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-control form-control-custom" value="{{ old('company_name', $profile->company_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Email <span class="text-danger">*</span></label>
                        <input type="email" name="company_email" class="form-control form-control-custom" value="{{ old('company_email', $profile->company_email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control form-control-custom" value="{{ old('contact_person', $profile->contact_person) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->phone) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Website</label>
                        <input type="url" name="website" class="form-control form-control-custom" value="{{ old('website', $profile->website) }}" placeholder="https://yourcompany.com">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Industry</label>
                        <input type="text" name="industry" class="form-control form-control-custom" value="{{ old('industry', $profile->industry) }}" placeholder="e.g. Technology, Finance">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Location / Address</label>
                        <textarea name="company_address" id="company_address" autocomplete="off" class="form-control form-control-custom" rows="3" placeholder="e.g. 123 Main Street, Dhaka, Bangladesh">{{ old('company_address', $profile->company_address) }}</textarea>
                        <div id="company-address-suggestions"></div>
                    </div>

                    <!-- Company Logo -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="file" id="company_logo_input" name="company_logo" class="d-none" accept="image/*" onchange="previewLogo(this)">
                            <button type="button" class="btn btn-sm btn-secondary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.8rem;" onclick="document.getElementById('company_logo_input').click()">
                                <i class="bi bi-upload"></i>
                                Change Logo
                            </button>
                            <p class="text-secondary mb-0" style="font-size: 0.75rem;">PNG or JPG, max 2 MB</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                        <i class="bi bi-check-lg"></i>
                        Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;" onclick="showViewMode()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function showEditMode() {
        document.getElementById('viewMode').style.display = 'none';
        document.getElementById('editMode').style.display = 'block';
        // Focus the first field
        document.querySelector('#editMode input[name="company_name"]').focus();
    }

    function showViewMode() {
        document.getElementById('editMode').style.display = 'none';
        document.getElementById('viewMode').style.display = 'block';
    }

    function previewLogo(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logoPreview');
            const icon = document.getElementById('logoPlaceholderIcon');
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            if (icon) icon.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    // If there were validation errors, automatically open edit mode
    @if($errors->any())
        showEditMode();
    @endif
</script>
<script src="{{ asset('js/location.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initLocationAutocomplete({
            searchInput: '#company_address',
            suggestionsContainer: '#company-address-suggestions',
        });
    });
</script>
@endsection