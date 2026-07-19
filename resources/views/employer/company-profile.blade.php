@extends('layouts.employer')

@section('title', 'Company Profile')
@section('header_title', 'Company Profile')
@section('header_subtitle', 'Manage your company information visible to applicants.')

@section('content')
<div class="container-fluid p-0">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #ECFDF5; color: #065F46;">
            <i class="bi bi-check-circle-fill me-2 text-emerald-500"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-triangle-fill me-2 text-rose-500"></i>
            <strong>Whoops! Please fix the errors below:</strong>
            <ul class="mb-0 mt-2 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-custom p-4">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-building text-secondary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Company Profile</h5>
                    <span class="text-secondary" style="font-size: 0.8rem;">Manage your company details</span>
                </div>
            </div>
            <button id="editToggleBtn" type="button" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;" onclick="toggleEdit()">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </button>
        </div>

        <form action="{{ route('employer.company-profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Company Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Name</label>
                    <input type="text" name="company_name" class="form-control form-control-custom" value="{{ old('company_name', $profile->company_name) }}" readonly required>
                </div>
                
                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Email</label>
                    <input type="email" name="company_email" class="form-control form-control-custom" value="{{ old('company_email', $profile->company_email) }}" readonly required>
                </div>

                <!-- Contact Person -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Contact Person</label>
                    <input type="text" name="contact_person" class="form-control form-control-custom" value="{{ old('contact_person', $profile->contact_person) }}" readonly>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Phone</label>
                    <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->phone) }}" readonly required>
                </div>

                <!-- Website -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Website</label>
                    <input type="url" name="website" class="form-control form-control-custom" value="{{ old('website', $profile->website) }}" readonly>
                </div>

                <!-- Industry -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Industry</label>
                    <input type="text" name="industry" class="form-control form-control-custom" value="{{ old('industry', $profile->industry) }}" readonly>
                </div>

                <!-- Location / Address -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Location / Address</label>
                    <textarea name="company_address" class="form-control form-control-custom" rows="3" readonly>{{ old('company_address', $profile->company_address) }}</textarea>
                </div>

                <!-- Company Logo Upload -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Logo</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center border" style="width: 70px; height: 70px; overflow: hidden;">
                            @if ($profile->company_logo)
                                <img id="logoPreview" src="{{ asset('storage/' . $profile->company_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div id="logoPlaceholder" class="d-flex flex-column align-items-center">
                                    <i class="bi bi-image text-secondary" style="font-size: 1.5rem;"></i>
                                </div>
                                <img id="logoPreview" src="" alt="Logo" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div>
                            <!-- Hidden input file -->
                            <input type="file" id="company_logo_input" name="company_logo" class="d-none" accept="image/*" onchange="previewLogo(this)" disabled>
                            
                            <button type="button" id="logoUploadBtn" class="btn btn-sm btn-secondary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.8rem;" onclick="document.getElementById('company_logo_input').click()" disabled>
                                <i class="bi bi-upload"></i>
                                Change Logo
                            </button>
                            <p class="text-secondary mt-1 mb-0" style="font-size: 0.7rem;">PNG or JPG, max 2 MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save & Cancel Buttons -->
            <div class="d-flex gap-3 mt-4 d-none" id="saveButtons">
                <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                    <i class="bi bi-check-lg"></i>
                    Save Changes
                </button>
                <button type="button" class="btn btn-secondary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;" onclick="toggleEdit()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleEdit() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea');
        const saveButtons = document.getElementById('saveButtons');
        const editToggleBtn = document.getElementById('editToggleBtn');
        const logoInput = document.getElementById('company_logo_input');
        const logoUploadBtn = document.getElementById('logoUploadBtn');
        
        const isReadonly = inputs[0].hasAttribute('readonly');

        inputs.forEach(input => {
            if (isReadonly) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', true);
            }
        });

        if (isReadonly) {
            // Enable file input & logo button
            logoInput.removeAttribute('disabled');
            logoUploadBtn.removeAttribute('disabled');
            
            // Show save/cancel controls
            saveButtons.classList.remove('d-none');
            editToggleBtn.classList.add('d-none');
        } else {
            // Reset form controls & disable logo button
            logoInput.setAttribute('disabled', true);
            logoUploadBtn.setAttribute('disabled', true);
            
            // Hide save/cancel controls
            saveButtons.classList.add('d-none');
            editToggleBtn.classList.remove('d-none');
        }
    }

    function previewLogo(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const logoPreview = document.getElementById('logoPreview');
                const logoPlaceholder = document.getElementById('logoPlaceholder');
                
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('d-none');
                
                if (logoPlaceholder) {
                    logoPlaceholder.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
