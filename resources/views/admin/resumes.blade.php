@extends('layouts.admin')

@section('title', 'Resume Reviews')
@section('header_title', 'Resume Reviews')
@section('header_subtitle', 'Track review status across all uploaded student resumes')

@section('content')
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-custom p-4">
    <div class="toolbar d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="tab-pills">
            <a href="{{ route('admin.resumes', ['status' => 'all']) }}" class="tab-pill {{ $currentTab === 'all' ? 'active' : '' }}">All ({{ $counts['all'] }})</a>
            <a href="{{ route('admin.resumes', ['status' => 'pending']) }}" class="tab-pill {{ $currentTab === 'pending' ? 'active' : '' }}">Pending ({{ $counts['pending'] }})</a>
            <a href="{{ route('admin.resumes', ['status' => 'reviewed']) }}" class="tab-pill {{ $currentTab === 'reviewed' ? 'active' : '' }}">Reviewed ({{ $counts['reviewed'] }})</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Resume File</th>
                    <th>Uploaded</th>
                    <th>Score</th>
                    <th>Reviewed By</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumes as $resume)
                    @php 
                        $student = $resume->studentProfile->user; 
                        $manualReview = $resume->manualReview;
                        $aiReview = $resume->aiReview;
                    @endphp
                    <tr>
                        <td style="font-weight:700;">{{ $student->name }}</td>
                        <td style="color:var(--muted);">{{ basename($resume->file_path) }}</td>
                        <td style="color:var(--muted);">{{ $resume->created_at->format('d M Y') }}</td>
                        <td>
                            @if($manualReview)
                                <span class="fw-bold text-dark">{{ $manualReview->overall_score }}/100</span>
                            @elseif($aiReview)
                                <span class="text-secondary" style="font-size: 0.85rem;"><i class="bi bi-stars" style="color:#4F46E5;"></i> {{ $aiReview->overall_score }}/100</span>
                            @else
                                —
                            @endif
                        </td>
                        <td style="color:var(--muted);">
                            @if($manualReview)
                                {{ $manualReview->reviewer ? $manualReview->reviewer->name : 'Recruiter' }}
                            @elseif($aiReview)
                                <span class="badge-custom-indigo" style="font-size:0.7rem;"><i class="bi bi-stars"></i> AI</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($manualReview)
                                <span class="badge-custom-emerald">Reviewed</span>
                            @elseif($aiReview)
                                <span class="badge-custom-indigo"><i class="bi bi-stars"></i> AI Reviewed</span>
                            @else
                                <span class="badge-custom-amber">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.resumes.download', $resume) }}" class="btn-ghost-custom btn-sm text-decoration-none">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                @if($manualReview)
                                    <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#viewReviewModal{{ $resume->id }}">View Review</button>
                                @endif
                                @if($aiReview)
                                    <button class="btn-ghost-custom btn-sm text-indigo" data-bs-toggle="modal" data-bs-target="#viewAiReviewModal{{ $resume->id }}">
                                        <i class="bi bi-stars"></i> AI Feedback
                                    </button>
                                @endif
                            </div>

                            <!-- View Human Review Modal -->
                            @if($manualReview)
                                <div class="modal fade" id="viewReviewModal{{ $resume->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0 rounded-4">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark m-0">Recruiter Review Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                    <span class="text-secondary">Overall Score</span>
                                                    <span class="badge bg-emerald-soft text-emerald fw-bold" style="font-size:0.9rem;">{{ $manualReview->overall_score }}/100</span>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="text-secondary d-block mb-1">Feedback</span>
                                                    <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-line; font-size: 0.85rem;">
                                                        {{ $manualReview->feedback }}
                                                    </div>
                                                </div>
                                                <div class="text-secondary" style="font-size:0.75rem;">
                                                    Reviewed by: <strong>{{ $manualReview->reviewer ? $manualReview->reviewer->name : 'Recruiter/Admin' }}</strong>
                                                    on {{ $manualReview->reviewed_at ? $manualReview->reviewed_at->format('d M Y, h:i A') : '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- View AI Review Modal -->
                            @if($aiReview)
                                <div class="modal fade" id="viewAiReviewModal{{ $resume->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0 rounded-4">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                                                    <i class="bi bi-stars" style="color:#4F46E5;"></i> AI Insights & Analysis
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                    <span class="text-secondary">AI Suggested Score</span>
                                                    <span class="badge bg-indigo-soft text-indigo fw-bold" style="font-size:0.9rem;">{{ $aiReview->overall_score }}/100</span>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="text-secondary d-block mb-1">AI Critique</span>
                                                    <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-line; font-size: 0.85rem; border-left: 3px solid #4F46E5;">
                                                        {{ $aiReview->feedback }}
                                                    </div>
                                                </div>
                                                <div class="text-secondary" style="font-size:0.75rem;">
                                                    Generated by: <strong>Gemini AI (2.5-flash)</strong>
                                                    on {{ $aiReview->reviewed_at ? $aiReview->reviewed_at->format('d M Y, h:i A') : '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Review Modal -->
                            <div class="modal fade" id="submitReviewModal{{ $resume->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 rounded-4">
                                        <form method="POST" action="{{ route('admin.resumes.review', $resume) }}">
                                            @csrf
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark m-0">Review Student Resume</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-4">
                                                @if($aiReview)
                                                    <div class="alert alert-info border-0 rounded-3 mb-3 d-flex gap-2" style="font-size: 0.8rem; background: #EEF2FF; color: #3730A3;">
                                                        <i class="bi bi-stars"></i>
                                                        <div>
                                                            <strong>AI Suggested Score: {{ $aiReview->overall_score }}/100</strong>. You can use the AI Feedback button behind this modal to guide your review.
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Overall Score (0 - 100)</label>
                                                    <input type="number" name="overall_score" min="0" max="100" class="form-control-custom" value="{{ $aiReview ? $aiReview->overall_score : '' }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Feedback & Suggestions</label>
                                                    <textarea name="feedback" rows="5" class="form-control-custom" placeholder="Provide actionable feedback for the student..." required>{{ $aiReview ? $aiReview->feedback : '' }}</textarea>
                                                </div>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn-primary-custom">Submit Review</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-secondary">No resumes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $resumes->links() }}
    </div>
</div>
@endsection