@extends('layouts.student')

@section('title', 'Profile')
@section('header_title', 'Profile')
@section('header_subtitle', 'Manage your personal information and career details.')

@section('content')
<div class="container-fluid p-0">
    <!-- Success Status Message -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Profile updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-custom p-4">
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs border-bottom mb-4" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-pane" type="button" role="tab" style="font-size: 0.85rem; color: #4F46E5; border-color: transparent transparent #4F46E5;">Personal Information</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-secondary" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-pane" type="button" role="tab" style="font-size: 0.85rem;">Education & Details</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="profileTabContent">

                <!-- Personal Information Tab -->
                <div class="tab-pane fade show active" id="personal-pane" role="tabpanel">
                    <div class="row g-4">
                        <!-- Left: Profile Photo -->
                        <div class="col-12 col-md-4 col-lg-3 text-center border-end">
                            <div class="mx-auto mb-3">
                                @if($user->studentProfile && $user->studentProfile->profile_picture)
                                    <img id="photo-preview" src="{{ asset('storage/' . $user->studentProfile->profile_picture) }}" alt="Profile Picture" class="rounded-circle object-cover mx-auto border" style="width: 100px; height: 100px;">
                                @else
                                    <div id="initials-avatar" class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto border" style="width: 100px; height: 100px; font-size: 2rem;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <label class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2 cursor-pointer" style="font-size: 0.8rem;">
                                <i class="bi bi-camera"></i>
                                Choose Photo
                                <input type="file" name="profile_picture" accept="image/*" class="d-none" onchange="previewProfilePhoto(this)">
                            </label>
                            @error('profile_picture') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                        </div>

                        <!-- Right: Form Fields -->
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-custom" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Email (Non-Editable)</label>
                                    <input type="email" class="form-control form-control-custom bg-light" value="{{ $user->email }}" readonly disabled>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Phone Number</label>
                                    <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->studentProfile->phone ?? '') }}" required placeholder="Enter your phone number">
                                    @error('phone') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education & Details Tab -->
                <div class="tab-pane fade" id="education-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">University</label>
                            <input type="text" name="university" class="form-control form-control-custom" value="{{ old('university', $user->studentProfile->university ?? '') }}" required placeholder="Enter your university name">
                            @error('university') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Department</label>
                            <input type="text" name="department" class="form-control form-control-custom" value="{{ old('department', $user->studentProfile->department ?? '') }}" required placeholder="Enter your department name">
                            @error('department') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Graduation Year</label>
                            <select name="graduation_year" class="form-select form-control-custom" required>
                                <option value="" disabled>Select graduation year</option>
                                @for ($year = date('Y') + 5; $year >= date('Y') - 10; $year--)
                                    <option value="{{ $year }}" {{ old('graduation_year', $user->studentProfile->graduation_year ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('graduation_year') <p class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button (Sticky at bottom of tab card) -->
            <div class="mt-4 pt-4 border-top">
                <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="padding: 0.7rem 1.5rem;">
                    <i class="bi bi-check-lg"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewProfilePhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('photo-preview');
                const initials = document.getElementById('initials-avatar');
                if (!img) {
                    // Create preview image element if not exists
                    img = document.createElement('img');
                    img.id = 'photo-preview';
                    img.className = 'rounded-circle object-cover mx-auto border';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    initials.replaceWith(img);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
