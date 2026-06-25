@extends('layouts.employer')

@section('title', 'Notifications')
@section('header_title', 'Notifications')
@section('header_subtitle', 'Stay updated with all activity related to your jobs and applicants.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">All Notifications</h5>
            <a href="#" class="text-decoration-none fw-semibold" style="font-size: 0.85rem; color: #4F46E5;">Mark all as read</a>
        </div>

        <!-- Notification List -->
        <div class="d-flex flex-column gap-2">

            <!-- Unread Notification -->
            <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background-color: #EEF2FF; border: 1px solid #E0E7FF;">
                <div class="icon-shape flex-shrink-0" style="background-color: #C7D2FE;">
                    <i class="bi bi-person-fill-add" style="color: #4F46E5;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-dark" style="font-size: 0.9rem;">
                        New application received for <strong>Backend Developer</strong>
                    </p>
                    <span class="text-secondary" style="font-size: 0.75rem;">2 hours ago</span>
                </div>
                <span class="badge rounded-pill" style="background-color: #4F46E5; width: 8px; height: 8px; padding: 0; min-width: 8px; margin-top: 6px;"></span>
            </div>

            <!-- Unread Notification -->
            <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background-color: #EEF2FF; border: 1px solid #E0E7FF;">
                <div class="icon-shape flex-shrink-0" style="background-color: #C7D2FE;">
                    <i class="bi bi-person-fill-add" style="color: #4F46E5;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-dark" style="font-size: 0.9rem;">
                        Tasnimul Islam applied for <strong>Laravel Developer</strong>
                    </p>
                    <span class="text-secondary" style="font-size: 0.75rem;">5 hours ago</span>
                </div>
                <span class="badge rounded-pill" style="background-color: #4F46E5; width: 8px; height: 8px; padding: 0; min-width: 8px; margin-top: 6px;"></span>
            </div>

            <!-- Read Notification -->
            <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                <div class="icon-shape flex-shrink-0" style="background-color: #ECFDF5;">
                    <i class="bi bi-calendar-check" style="color: #10B981;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-dark" style="font-size: 0.9rem;">
                        Interview scheduled with <strong>Raihan Uddin</strong> on 22 May 2024
                    </p>
                    <span class="text-secondary" style="font-size: 0.75rem;">1 day ago</span>
                </div>
            </div>

            <!-- Read Notification -->
            <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                <div class="icon-shape flex-shrink-0" style="background-color: #FEF3C7;">
                    <i class="bi bi-check-circle" style="color: #D97706;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-dark" style="font-size: 0.9rem;">
                        Sadia Akter accepted your interview invitation.
                    </p>
                    <span class="text-secondary" style="font-size: 0.75rem;">1 day ago</span>
                </div>
            </div>

            <!-- Read Notification -->
            <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background-color: #F9FAFB; border: 1px solid #E5E7EB;">
                <div class="icon-shape flex-shrink-0" style="background-color: #ECFDF5;">
                    <i class="bi bi-megaphone" style="color: #10B981;"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-dark" style="font-size: 0.9rem;">
                        Your job posting <strong>Laravel Developer</strong> is now active.
                    </p>
                    <span class="text-secondary" style="font-size: 0.75rem;">2 days ago</span>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#" style="background-color: #4F46E5; border-color: #4F46E5;">1</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                    <li class="page-item">
                        <a class="page-link text-dark" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
