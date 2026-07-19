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

    @if(session('status') == 'status-updated')
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            Application status updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('status') == 'review-submitted')
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            Resume review submitted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('status') == 'notes-updated')
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            Internal notes updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Applicant Info -->
        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4 text-center">
                <!-- Avatar -->
                <div class="mx-auto mb-3">
                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold mx-auto" style="width: 80px; height: 80px; font-size: 1.5rem;">
                        {{ strtoupper(substr($application->student->name, 0, 2)) }}
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
                        @if($application->status === 'Withdrawn')
                            <span class="badge bg-secondary text-white mt-1 py-2 px-3 rounded" style="font-size: 0.85rem;">Withdrawn</span>
                        @else
                            <form action="{{ route('employer.applicants.status.update', $application) }}" method="POST" id="statusUpdateForm">
                                @csrf
                                <select name="status" class="form-select form-control-custom mt-1" style="font-size: 0.85rem;" onchange="document.getElementById('statusUpdateForm').submit();">
                                    <option value="Applied" {{ $application->status === 'Applied' ? 'selected' : '' }}>Applied</option>
                                    <option value="Under Review" {{ $application->status === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                                    <option value="Shortlisted" {{ $application->status === 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="Interview" {{ $application->status === 'Interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="Hired" {{ $application->status === 'Hired' ? 'selected' : '' }}>Hired</option>
                                    <option value="Rejected" {{ $application->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 mt-3">
                    @if(!in_array($application->status, ['Withdrawn', 'Rejected', 'Hired']))
                        <a href="{{ route('employer.schedule-interview', ['application_id' => $application->id]) }}" class="btn btn-primary-custom d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1rem; background-color: #4F46E5; border-color: #4F46E5;">
                            <i class="bi bi-calendar-event"></i>
                            Schedule Interview
                        </a>
                    @endif
                    <div class="d-flex gap-2">
                        @php
                            $latestResume = $application->student->studentProfile?->latestResume;
                        @endphp
                        @if($latestResume)
                            <a href="{{ asset('storage/' . $latestResume->file_path) }}" target="_blank" class="btn btn-secondary-custom flex-grow-1 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1rem;">
                                <i class="bi bi-download"></i>
                                Download Resume
                            </a>
                        @else
                            <button type="button" disabled class="btn btn-secondary-custom flex-grow-1 d-flex align-items-center justify-content-center gap-2 opacity-50" style="font-size: 0.85rem; padding: 0.6rem 1rem;">
                                <i class="bi bi-file-earmark-slash"></i>
                                No Resume
                            </button>
                        @endif
                        <button type="button" class="btn btn-secondary-custom flex-grow-1 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1rem;" onclick="new bootstrap.Tab(document.getElementById('cover-tab')).show();">
                            <i class="bi bi-envelope"></i>
                            Cover Letter
                        </button>
                    </div>
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-secondary" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-pane" type="button" role="tab" style="font-size: 0.85rem;">Resume Review</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="applicantTabContent">
                    <!-- Resume Tab -->
                    <div class="tab-pane fade show active" id="resume-pane" role="tabpanel">
                        @if($latestResume)
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                                <div class="icon-shape" style="background-color: #EEF2FF;">
                                    <i class="bi bi-file-earmark-pdf text-primary" style="font-size: 1.2rem; color: #4F46E5 !important;"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.9rem;">{{ basename($latestResume->file_path) }}</h6>
                                    <span class="text-secondary" style="font-size: 0.75rem;">
                                        Uploaded on {{ $latestResume->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <a href="{{ asset('storage/' . $latestResume->file_path) }}" target="_blank" class="ms-auto btn btn-sm btn-light border rounded-3 d-flex align-items-center gap-1">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                            <div class="mt-4" style="height: 550px;">
                                <iframe src="{{ asset('storage/' . $latestResume->file_path) }}" class="w-100 h-100 border rounded-3 shadow-sm"></iframe>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-secondary mb-2" style="font-size: 2rem;">
                                    <i class="bi bi-file-earmark-slash"></i>
                                </div>
                                <p class="text-secondary mb-0">No resume has been uploaded by the applicant yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Cover Letter Tab -->
                    <div class="tab-pane fade" id="cover-pane" role="tabpanel">
                        @if($application->cover_letter)
                            <div class="p-4 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                                <p class="text-dark mb-0" style="font-size: 0.95rem; line-height: 1.8; white-space: pre-line;">
                                    {{ $application->cover_letter }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-secondary mb-2" style="font-size: 2rem;">
                                    <i class="bi bi-envelope-slash"></i>
                                </div>
                                <p class="text-secondary mb-0">No cover letter was submitted with this application.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Tab -->
                    <div class="tab-pane fade" id="profile-pane" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Full Name</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->name }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Email</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->email }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Phone</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->studentProfile?->phone ?? 'Not Provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">University</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->studentProfile?->university ?? 'Not Provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Department</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->studentProfile?->department ?? 'Not Provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-secondary d-block" style="font-size: 0.75rem;">Graduation Year</span>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $application->student->studentProfile?->graduation_year ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Tab -->
                    <div class="tab-pane fade" id="experience-pane" role="tabpanel">
                        <div class="p-4 rounded-3 text-center" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                            <div class="text-secondary mb-3" style="font-size: 2rem;">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2">Detailed Work History Available in Resume</h6>
                            <p class="text-secondary mb-3" style="font-size: 0.85rem; max-width: 500px; margin: 0 auto;">
                                Detailed career timeline, project roles, and employment history are fully described in the candidate's uploaded resume.
                            </p>
                            <button type="button" class="btn btn-sm btn-outline-primary" style="border-color: #4F46E5; color: #4F46E5;" onclick="new bootstrap.Tab(document.getElementById('resume-tab')).show();">
                                View Resume
                            </button>
                        </div>
                    </div>

                    <!-- Skills Tab -->
                    <div class="tab-pane fade" id="skills-pane" role="tabpanel">
                        @if($application->student->studentProfile && $application->student->studentProfile->skills->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($application->student->studentProfile->skills as $skill)
                                    <span class="badge-custom-indigo px-3 py-2" style="font-size: 0.8rem;">
                                        {{ $skill->name }} ({{ $skill->level ?? 'Proficient' }})
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-secondary mb-2" style="font-size: 2rem;">
                                    <i class="bi bi-tag-slash"></i>
                                </div>
                                <p class="text-secondary mb-0">No specific skills have been added to the profile yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Resume Review Tab -->
                    <div class="tab-pane fade" id="review-pane" role="tabpanel">
                        @php
                            $latestResume = $application->student->studentProfile?->latestResume;
                            $manualReview = $latestResume?->manualReview;
                            $aiReview = $latestResume?->aiReview;
                        @endphp

                        @if(!$latestResume)
                            <p class="text-secondary mb-0" style="font-size: 0.85rem;">This applicant has not uploaded a resume yet.</p>
                        @else
                            @if($manualReview)
                                <div class="p-3 rounded-3 mb-4" style="background-color: #ECFDF5; border: 1px solid #A7F3D0;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold text-emerald" style="font-size: 0.9rem;">Your Review (Manual)</span>
                                        <span class="badge bg-emerald-soft text-emerald px-3 py-1" style="font-size: 0.8rem;">{{ $manualReview->overall_score }}/100</span>
                                    </div>
                                    <p class="text-secondary mb-1" style="font-size: 0.83rem; white-space: pre-line;">{{ $manualReview->feedback }}</p>
                                    <span class="text-secondary" style="font-size: 0.72rem;">
                                        Reviewed on {{ $manualReview->reviewed_at?->format('d M Y') }} by {{ $manualReview->reviewer ? $manualReview->reviewer->name : 'You' }}
                                    </span>
                                </div>
                            @endif

                            @if($aiReview)
                                <div class="p-3 rounded-3 mb-4 text-indigo" style="background-color: #EEF2FF; border: 1px solid #C7D2FE;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                                            <i class="bi bi-stars"></i> Gemini AI Analysis
                                        </span>
                                        <span class="badge bg-indigo-soft text-indigo px-3 py-1" style="font-size: 0.8rem;">{{ $aiReview->overall_score }}/100</span>
                                    </div>
                                    <p class="text-secondary mb-1" style="font-size: 0.83rem; white-space: pre-line;">{{ $aiReview->feedback }}</p>
                                    <span class="text-secondary" style="font-size: 0.72rem;">
                                        Generated on {{ $aiReview->reviewed_at?->format('d M Y') }}
                                    </span>
                                </div>
                            @endif

                            <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                                {{ $manualReview ? 'Update Your Review' : 'Submit a Review' }}
                            </h6>
                            <form action="{{ route('employer.applicant-details.resume-review', $application) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 0.82rem;">Overall Score (0-100)</label>
                                    <input type="number" name="overall_score" min="0" max="100" required
                                        class="form-control form-control-custom" style="font-size: 0.85rem;"
                                        value="{{ old('overall_score', $manualReview ? $manualReview->overall_score : ($aiReview ? $aiReview->overall_score : '')) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 0.82rem;">Feedback</label>
                                    <textarea name="feedback" rows="4" required
                                        class="form-control form-control-custom" style="font-size: 0.85rem;"
                                        placeholder="Strengths, weaknesses, and suggestions for this resume..."
                                    >{{ old('feedback', $manualReview ? $manualReview->feedback : ($aiReview ? $aiReview->feedback : '')) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                                    <i class="bi bi-send-check"></i> {{ $manualReview ? 'Update Review' : 'Submit Review' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="border-top border-light pt-4 mt-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">Notes (Internal)</h6>
                    <form action="{{ route('employer.applicant-details.notes.update', $application) }}" method="POST">
                        @csrf
                        <textarea name="employer_notes" class="form-control form-control-custom" rows="3" placeholder="Add private notes about this candidate's interview performance, fit, or follow-ups...">{{ old('employer_notes', $application->employer_notes) }}</textarea>
                        <button type="submit" class="btn btn-primary-custom mt-3 d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                            <i class="bi bi-save"></i>
                            Save Note
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection