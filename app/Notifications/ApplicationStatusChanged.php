<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public JobApplication $application,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $iconMap = [
            'Under Review' => ['icon' => 'bi-hourglass-split', 'bg' => '#FEF3C7', 'color' => '#D97706'],
            'Shortlisted' => ['icon' => 'bi-star-fill', 'bg' => '#EEF2FF', 'color' => '#4F46E5'],
            'Interview' => ['icon' => 'bi-camera-video-fill', 'bg' => '#FEF3C7', 'color' => '#D97706'],
            'Hired' => ['icon' => 'bi-trophy-fill', 'bg' => '#ECFDF5', 'color' => '#059669'],
            'Rejected' => ['icon' => 'bi-x-circle-fill', 'bg' => '#FFF1F2', 'color' => '#F43F5E'],
        ];

        $style = $iconMap[$this->newStatus] ?? ['icon' => 'bi-arrow-up-circle-fill', 'bg' => '#ECFDF5', 'color' => '#10B981'];

        return [
            'type' => 'status_changed',
            'icon' => $style['icon'],
            'icon_bg' => $style['bg'],
            'icon_color' => $style['color'],
            'title' => 'Application status updated to ' . $this->newStatus . '.',
            'message' => 'Your application for ' . $this->application->jobListing->title . ' at ' . ($this->application->jobListing->user->name ?? 'Company') . ' has been moved from ' . $this->oldStatus . ' to ' . $this->newStatus . '.',
            'job_id' => $this->application->job_listing_id,
            'application_id' => $this->application->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
