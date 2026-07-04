<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
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
            'type' => 'new_application',
            'icon' => 'bi-person-fill-add',
            'icon_bg' => '#EEF2FF',
            'icon_color' => '#4F46E5',
            'title' => 'New application received for ' . $this->application->jobListing->title . '.',
            'message' => ($this->application->student->name ?? 'A student') . ' applied for ' . $this->application->jobListing->title . '.',
            'job_id' => $this->application->job_listing_id,
            'application_id' => $this->application->id,
            'student_id' => $this->application->student_id,
        ];
    }
}
