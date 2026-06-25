@extends('layouts.student')

@section('title', 'Profile')
@section('header_title', 'Profile')
@section('header_subtitle', 'Manage your personal information and career details.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs border-bottom mb-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-pane" type="button" role="tab" style="font-size: 0.85rem; color: #4F46E5; border-color: transparent transparent #4F46E5;">Personal Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold text-secondary" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-pane" type="button" role="tab" style="font-size: 0.85rem;">Education</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold text-secondary" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience-pane" type="button" role="tab" style="font-size: 0.85rem;">Experience</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="profileTabContent">

            <!-- Personal Information Tab -->
            <div class="tab-pane fade show active" id="personal-pane" role="tabpanel">
                <div class="row g-4">
                    <!-- Left: Profile Photo -->
                    <div class="col-12 col-md-4 col-lg-3 text-center">
                        <div class="mx-auto mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto" style="width: 100px; height: 100px; font-size: 2rem;">
                                RU
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-custom d-inline-flex align-items-center gap-2" style="font-size: 0.8rem;">
                            <i class="bi bi-camera"></i>
                            Change Photo
                        </button>
                    </div>

                    <!-- Right: Form Fields -->
                    <div class="col-12 col-md-8 col-lg-9">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Full Name</label>
                                    <input type="text" class="form-control form-control-custom" value="Raihan Uddin">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Email</label>
                                    <input type="email" class="form-control form-control-custom" value="raihan@example.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Phone</label>
                                    <input type="text" class="form-control form-control-custom" value="+880 1712-345678">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Date of Birth</label>
                                    <input type="text" class="form-control form-control-custom" value="12 May 2001">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Address</label>
                                    <input type="text" class="form-control form-control-custom" value="Mirpur, Dhaka, Bangladesh">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="padding: 0.7rem 1.5rem;">
                                    <i class="bi bi-check-lg"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Education Tab -->
            <div class="tab-pane fade" id="education-pane" role="tabpanel">
                <div class="d-flex flex-column gap-4">
                    <!-- Education Entry 1 -->
                    <div class="p-3 border border-light-subtle rounded-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">BSc in Computer Science & Engineering</h6>
                                <span class="text-secondary" style="font-size: 0.8rem;">Daffodil International University</span>
                                <br>
                                <span class="text-secondary" style="font-size: 0.75rem;">2019 - 2023 &bull; CGPA: 3.45 / 4.00</span>
                            </div>
                            <button class="btn btn-sm btn-light border rounded-3"><i class="bi bi-pencil"></i></button>
                        </div>
                    </div>

                    <!-- Education Entry 2 -->
                    <div class="p-3 border border-light-subtle rounded-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">HSC in Science</h6>
                                <span class="text-secondary" style="font-size: 0.8rem;">Dhaka City College</span>
                                <br>
                                <span class="text-secondary" style="font-size: 0.75rem;">2017 - 2019 &bull; GPA: 5.00 / 5.00</span>
                            </div>
                            <button class="btn btn-sm btn-light border rounded-3"><i class="bi bi-pencil"></i></button>
                        </div>
                    </div>

                    <button class="btn btn-outline-custom d-inline-flex align-items-center gap-2 align-self-start" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                        <i class="bi bi-plus-lg"></i>
                        Add Education
                    </button>
                </div>
            </div>

            <!-- Experience Tab -->
            <div class="tab-pane fade" id="experience-pane" role="tabpanel">
                <div class="d-flex flex-column gap-4">
                    <!-- Experience Entry 1 -->
                    <div class="p-3 border border-light-subtle rounded-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Junior Web Developer</h6>
                                <span class="text-secondary" style="font-size: 0.8rem;">WebCraft BD &bull; Intern</span>
                                <br>
                                <span class="text-secondary" style="font-size: 0.75rem;">Jun 2023 - Dec 2023</span>
                                <p class="text-secondary mt-2 mb-0" style="font-size: 0.8rem;">
                                    Built client websites using Laravel and Bootstrap. Assisted in database design and REST API development.
                                </p>
                            </div>
                            <button class="btn btn-sm btn-light border rounded-3"><i class="bi bi-pencil"></i></button>
                        </div>
                    </div>

                    <button class="btn btn-outline-custom d-inline-flex align-items-center gap-2 align-self-start" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                        <i class="bi bi-plus-lg"></i>
                        Add Experience
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
