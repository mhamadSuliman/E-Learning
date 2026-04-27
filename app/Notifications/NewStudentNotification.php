<?php

namespace App\Notifications;
use Illuminate\Support\Facades\Log;

use App\Models\course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStudentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $student;
    public $course;

    public function __construct(User $student,course $course)
    {
        $this->student=$student;
        $this->course=$course;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'student_id'=>$this->student->id,
            'Student_name'=>$this->student->name,
            'course_id'=>$this->course->id,
            'course_title'=>$this->course->title,
            'message'=>"تم اضافة طالب جديد:{$this->student->name}في الكورس :{$this->course->title}",
        ];
    }
     public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
 public function toBroadcast($notifiable)
    {
        Log::info('📢 تم إرسال إشعار بث مباشر', [
            'to' => $notifiable->id,
            'student' => $this->student->name,
            'course' => $this->course->title,
        ]);

        return new BroadcastMessage($this->toArray($notifiable));
    }
}
