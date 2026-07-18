<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewCancelled extends Notification
{
    use Queueable;

    public function __construct(public Interview $interview) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'interview_cancelled',
            'icon' => 'bi-calendar-x-fill',
            'icon_bg' => '#FFF1F2',
            'icon_color' => '#F43F5E',
            'title' => 'Interview Cancelled',
            'message' => 'The scheduled interview for ' . $this->interview->jobApplication->jobListing->title . ' at ' . ($this->interview->employer->name ?? 'Company') . ' has been cancelled.',
            'job_id' => $this->interview->jobApplication->job_listing_id,
            'application_id' => $this->interview->job_application_id,
            'interview_id' => $this->interview->id,
        ];
    }
}
