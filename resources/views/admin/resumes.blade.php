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
                        $latestReview = $resume->latestReview;
                    @endphp
                    <tr>
                        <td style="font-weight:700;">{{ $student->name }}</td>
                        <td style="color:var(--muted);">{{ basename($resume->file_path) }}</td>
                        <td style="color:var(--muted);">{{ $resume->created_at->format('d M Y') }}</td>
                        <td>{{ $latestReview ? ($latestReview->overall_score . '/100') : '—' }}</td>
                        <td style="color:var(--muted);">{{ $latestReview && $latestReview->reviewer ? $latestReview->reviewer->name : '—' }}</td>
                        <td>
                            @if($resume->status === 'reviewed')
                                <span class="badge-custom-emerald">Reviewed</span>
                            @else
                                <span class="badge-custom-amber">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.resumes.download', $resume) }}" class="btn-ghost-custom btn-sm text-decoration-none">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                @if($resume->status === 'reviewed')
                                    <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#viewReviewModal{{ $resume->id }}">View Review</button>
                                @else
                                    <button class="btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#submitReviewModal{{ $resume->id }}">Review Now</button>
                                @endif
                            </div>

                            <!-- View Review Modal -->
                            @if($latestReview)
                                <div class="modal fade" id="viewReviewModal{{ $resume->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0 rounded-4">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark m-0">Resume Review Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                    <span class="text-secondary">Overall Score</span>
                                                    <span class="badge-custom-indigo" style="font-size:0.9rem;">{{ $latestReview->overall_score }}/100</span>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="text-secondary d-block mb-1">Feedback</span>
                                                    <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-line; font-size: 0.85rem;">
                                                        {{ $latestReview->feedback }}
                                                    </div>
                                                </div>
                                                <div class="text-secondary" style="font-size:0.75rem;">
                                                    Reviewed by: <strong>{{ $latestReview->reviewer ? $latestReview->reviewer->name : 'System/Deleted' }}</strong>
                                                    on {{ $latestReview->reviewed_at ? $latestReview->reviewed_at->format('d M Y, h:i A') : '—' }}
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
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Overall Score (0 - 100)</label>
                                                    <input type="number" name="overall_score" min="0" max="100" class="form-control-custom" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Feedback & Suggestions</label>
                                                    <textarea name="feedback" rows="5" class="form-control-custom" placeholder="Provide actionable feedback for the student..." required></textarea>
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
