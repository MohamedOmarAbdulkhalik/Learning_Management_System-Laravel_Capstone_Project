<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Submission;

class SubmissionSubmitted extends Notification
{
    use Queueable;

    public $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $assignment = $this->submission->assignment;
        $course = $assignment->lesson->course;

        return (new MailMessage)
                    ->subject("New submission: {$assignment->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("Student {$this->submission->student->name} submitted a solution for the assignment: {$assignment->title}.")
                    ->action('View Submission', route('submissions.show', $this->submission))
                    ->line("Course: {$course->title}");
    }

    public function toArray($notifiable)
    {
        $assignment = $this->submission->assignment;
        $course = $assignment->lesson->course;

        return [
            'type' => 'submission_submitted',
            'title' => "New submission for {$assignment->title}",
            'message' => "{$this->submission->student->name} submitted a solution.",
            'submission_id' => $this->submission->id,
            'assignment_id' => $assignment->id,
            'lesson_id' => $assignment->lesson->id,
            'course_id' => $course->id,
            'url' => route('submissions.show', $this->submission),
        ];
    }
}
