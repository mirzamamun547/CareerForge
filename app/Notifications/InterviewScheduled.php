<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewScheduled extends Notification
{
    use Queueable;

    public function __construct(public Interview $interview) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $typeLabel = ucfirst($this->interview->type);
        $timeStr = $this->interview->scheduled_at->format('d M Y, h:i A');

        return [
            'type' => 'interview_scheduled',
            'icon' => 'bi-calendar-event-fill',
            'icon_bg' => '#EEF2FF',
            'icon_color' => '#4F46E5',
            'title' => 'New Interview Scheduled',
            'message' => 'An interview for ' . $this->interview->jobApplication->jobListing->title . ' at ' . ($this->interview->employer->name ?? 'Company') . ' has been scheduled on ' . $timeStr . ' (' . $typeLabel . ').',
            'job_id' => $this->interview->jobApplication->job_listing_id,
            'application_id' => $this->interview->job_application_id,
            'interview_id' => $this->interview->id,
        ];
    }
}
