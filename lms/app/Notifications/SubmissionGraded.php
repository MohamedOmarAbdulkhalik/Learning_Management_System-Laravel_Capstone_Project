<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Submission;

class SubmissionGraded extends Notification
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
                    ->subject("Your submission was graded: {$assignment->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("Your submission for assignment '{$assignment->title}' was graded.")
                    ->line("Grade: " . ($this->submission->grade ?? 'N/A'))
                    ->action('View Submission', route('submissions.show', $this->submission))
                    ->line("Course: {$course->title}");
    }

    public function toArray($notifiable)
    {
        $assignment = $this->submission->assignment;
        $course = $assignment->lesson->course;

        return [
            'type' => 'submission_graded',
            'title' => "Your submission for {$assignment->title} was graded",
            'message' => "Grade: " . ($this->submission->grade ?? 'N/A'),
            'submission_id' => $this->submission->id,
            'assignment_id' => $assignment->id,
            'lesson_id' => $assignment->lesson->id,
            'course_id' => $course->id,
            'url' => route('submissions.show', $this->submission),
        ];
    }
}
