<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public JobApplication $application
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'application_submitted',
            'icon' => 'bi-send-fill',
            'icon_bg' => '#ECFDF5',
            'icon_color' => '#10B981',
            'title' => 'Application submitted successfully.',
            'message' => 'Your application for ' . $this->application->jobListing->title . ' at ' . ($this->application->jobListing->user->name ?? 'Company') . ' was submitted.',
            'job_id' => $this->application->job_listing_id,
            'application_id' => $this->application->id,
        ];
    }
}
