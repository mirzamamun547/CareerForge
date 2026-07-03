@extends('layouts.student')

@section('title', 'Resume Upload')
@section('header_title', 'Upload Your Resume')
@section('header_subtitle', 'Upload your resume (PDF, DOC, DOCX) for review.')

@push('styles')
<style>
    .upload-zone {
        border: 2px dashed #D1D5DB;
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
        background-color: #FAFBFC;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #4F46E5;
        background-color: #EEF2FF;
    }
    .upload-zone .upload-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        background-color: #EEF2FF;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Success Status Message -->
    @if (session('status') === 'resume-uploaded')
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Resume uploaded successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Upload Section -->
        <div class="col-12">
            <div class="card card-custom p-4">

                <!-- Upload Form -->
                <form id="resumeUploadForm" method="POST" action="{{ route('student.resume.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Drag & Drop Zone -->
                    <div class="upload-zone" id="uploadZone">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up" style="font-size: 1.5rem; color: #4F46E5;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Drag & Drop your file here</h6>
                        <p class="text-secondary mb-3" style="font-size: 0.8rem;">or</p>
                        <label for="fileInput" class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.5rem; cursor: pointer;">
                            <i class="bi bi-folder2-open"></i>
                            Browse File
                        </label>
                        <input type="file" name="resume" id="fileInput" class="d-none" accept=".pdf,.doc,.docx" onchange="autoSubmitForm()">
                    </div>
                </form>
                @error('resume') <p class="text-danger mt-2 text-center font-medium" style="font-size: 0.8rem;">{{ $message }}</p> @enderror

                <!-- Uploaded Resume Section -->
                <div class="mt-4 pt-4 border-top border-light">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.95rem;">Uploaded Resume</h6>

                    @if ($latestResume)
                        @php
                            $filename = basename($latestResume->file_path);
                            $exists = Storage::disk('public')->exists($latestResume->file_path);
                            $size = $exists ? round(Storage::disk('public')->size($latestResume->file_path) / 1024, 1) . ' KB' : 'Unknown size';
                            $uploadedAt = $latestResume->created_at->format('d M Y, h:i A');
                        @endphp
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                            <div class="icon-shape flex-shrink-0" style="background-color: #EEF2FF;">
                                <i class="bi bi-file-earmark-pdf" style="font-size: 1.2rem; color: #4F46E5;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $filename }}</h6>
                                <span class="text-secondary" style="font-size: 0.7rem;">Uploaded on: {{ $uploadedAt }} &bull; {{ $size }}</span>
                            </div>
                            <a href="{{ route('student.resume.download') }}" class="btn btn-sm btn-light border rounded-3 d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    @else
                        <div class="p-4 text-center rounded-3 bg-light text-secondary border border-dashed">
                            <i class="bi bi-info-circle fs-4 mb-2 d-block"></i>
                            No resume uploaded yet. Drag a file above to get started!
                        </div>
                    @endif

                    <p class="text-secondary mt-3 mb-0" style="font-size: 0.75rem;">
                        <i class="bi bi-info-circle"></i>
                        Max file size: 5MB &bull; Format: PDF, DOC, DOCX
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const uploadForm = document.getElementById('resumeUploadForm');

    ['dragenter', 'dragover'].forEach(event => {
        uploadZone.addEventListener(event, (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(event => {
        uploadZone.addEventListener(event, (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
        });
    });

    uploadZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            autoSubmitForm();
        }
    });

    uploadZone.addEventListener('click', (e) => {
        if (e.target.tagName !== 'LABEL' && e.target.tagName !== 'INPUT') {
            fileInput.click();
        }
    });

    function autoSubmitForm() {
        if (fileInput.files.length > 0) {
            uploadForm.submit();
        }
    }
</script>
@endpush