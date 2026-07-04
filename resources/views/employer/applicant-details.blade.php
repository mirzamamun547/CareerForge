@extends('layouts.employer')

@section('title', 'Applicant Details')
@section('header_title', 'Applicant Details')
@section('header_subtitle', 'Review the applicant\'s profile, resume, and application materials.')

@section('content')
<div class="container-fluid p-0">

    <!-- Back to list -->
    <a href="/employer/applicants" class="d-inline-flex align-items-center gap-2 text-decoration-none text-secondary mb-4" style="font-size: 0.85rem;">
        <i class="bi bi-arrow-left"></i>
        Back to List
    </a>

    <div class="row g-4">
        <!-- Left Column: Applicant Info -->
        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4 text-center">
                <!-- Avatar -->
                <div class="mx-auto mb-3">
                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto" style="width: 80px; height: 80px; font-size: 1.5rem;">
                        RU
                    </div>
                </div>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;">{{ $application->student->name }}</h5>
                <p class="text-secondary mb-1" style="font-size: 0.8rem;">{{ $application->student->email }}</p>

                <div class="border-top border-light pt-3 mt-3 text-start">
                    <div class="mb-3">
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Applied For</span>
                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $application->jobListing->title }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Applied On</span>
                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $application->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Location</span>
                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $application->jobListing->location }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="text-secondary d-block" style="font-size: 0.75rem;">Current Status</span>
                        <select class="form-select form-control-custom mt-1" style="font-size: 0.85rem;">
                            <option selected>{{ $application->status }}</option>
                            <option>Shortlisted</option>
                            <option>Interview</option>
                            <option>Hired</option>
                            <option>Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <a href="#" class="btn btn-primary-custom flex-grow-1 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1rem;">
                        <i class="bi bi-download"></i>
                        Download Resume
                    </a>
                    <a href="#" class="btn btn-secondary-custom d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1rem;">
                        <i class="bi bi-envelope"></i>
                        View Cover Letter
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Details Tabs -->
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs border-bottom mb-4" id="applicantTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="resume-tab" data-bs-toggle="tab" data-bs-target="#resume-pane" type="button" role="tab" style="font-size: 0.85rem; color: #4F46E5; border-color: transparent transparent #4F46E5;">Resume</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-secondary" id="cover-tab" data-bs-toggle="tab" data-bs-target="#cover-pane" type="button" role="tab" style="font-size: 0.85rem;">Cover Letter</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-secondary" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-pane" type="button" role="tab" style="font-size: 0.85rem;">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-secondary" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience-pane" type="button" role="tab" style="font-size: 0.85rem;">Experience</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-secondary" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills-pane" type="button" role="tab" style="font-size: 0.85rem;">Skills</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="applicantTabContent">
                    <!-- Resume Tab -->
                    <div class="tab-pane fade show active" id="resume-pane" role="tabpanel">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                            <div class="icon-shape" style="background-color: #EEF2FF;">
                                <i class="bi bi-file-earmark-pdf text-primary" style="font-size: 1.2rem; color: #4F46E5 !important;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">Raihan_Uddin_Resume.pdf</h6>
                                <span class="text-secondary" style="font-size: 0.75rem;">(120 KB)</span>
                            </div>
                            <a href="#" class="ms-auto btn btn-sm btn-light border rounded-3">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Cover Letter Tab -->
                    <div class="tab-pane fade" id="cover-pane" role="tabpanel">
                        <p class="text-secondary" style="font-size: 0.9rem; line-height: 1.8;">
                            Dear Hiring Manager,<br><br>
                            I am writing to express my interest in the Backend Developer position at TechSoft Ltd. With over 3 years of experience in building scalable web applications using Laravel and PHP, I believe I would be a strong addition to your engineering team.<br><br>
                            In my current role, I have successfully architected RESTful APIs that serve over 10,000 daily requests, optimized database queries to reduce response times by 40%, and implemented CI/CD pipelines using GitHub Actions.<br><br>
                            I am excited about the opportunity to bring my skills and passion for clean code to your organization.<br><br>
                            Best regards,<br>
                            Raihan Uddin
                        </p>
                    </div>

                    <!-- Profile Tab -->
                    <div class="tab-pane fade" id="profile-pane" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Full Name</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">Raihan Uddin</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Email</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">raihan@example.com</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Phone</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">+880 1712-345678</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Location</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">Dhaka, Bangladesh</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Date of Birth</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">15 March 1997</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">LinkedIn</span>
                                <a href="#" class="fw-semibold" style="font-size: 0.9rem; color: #4F46E5;">linkedin.com/in/raihanuddin</a>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Tab -->
                    <div class="tab-pane fade" id="experience-pane" role="tabpanel">
                        <div class="mb-4 pb-3 border-bottom border-light">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Backend Developer</h6>
                            <span class="text-secondary" style="font-size: 0.8rem;">DataSoft Ltd. &bull; Jan 2022 - Present</span>
                            <p class="text-secondary mt-2 mb-0" style="font-size: 0.85rem;">
                                Developed and maintained REST APIs using Laravel. Managed MySQL databases and optimized query performance. Collaborated with frontend teams on SPA integrations.
                            </p>
                        </div>
                        <div class="mb-2">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Junior Developer</h6>
                            <span class="text-secondary" style="font-size: 0.8rem;">WebCraft BD &bull; Jun 2020 - Dec 2021</span>
                            <p class="text-secondary mt-2 mb-0" style="font-size: 0.85rem;">
                                Built client websites using PHP and WordPress. Assisted in database design and implemented payment gateway integrations.
                            </p>
                        </div>
                    </div>

                    <!-- Skills Tab -->
                    <div class="tab-pane fade" id="skills-pane" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">PHP</span>
                            <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">Laravel</span>
                            <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">MySQL</span>
                            <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">REST APIs</span>
                            <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">Git</span>
                            <span class="badge-custom-emerald px-3 py-2" style="font-size: 0.8rem;">Docker</span>
                            <span class="badge-custom-emerald px-3 py-2" style="font-size: 0.8rem;">Redis</span>
                            <span class="badge-custom-emerald px-3 py-2" style="font-size: 0.8rem;">JavaScript</span>
                            <span class="badge-custom-amber px-3 py-2" style="font-size: 0.8rem;">AWS</span>
                            <span class="badge-custom-amber px-3 py-2" style="font-size: 0.8rem;">CI/CD</span>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="border-top border-light pt-4 mt-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">Notes</h6>
                    <textarea class="form-control form-control-custom" rows="3" placeholder="Add your notes about this applicant..."></textarea>
                    <button class="btn btn-primary-custom mt-3 d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                        <i class="bi bi-save"></i>
                        Save Note
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
