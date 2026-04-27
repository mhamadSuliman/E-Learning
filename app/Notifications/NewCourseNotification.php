<?php

namespace App\Notifications;
use Illuminate\Support\Facades\Log;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewCourseNotification extends Notification
{
    use Queueable;

    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id' => $this->course->id,
            'title' => $this->course->title,
            'image' => $this->course->image,
        ];
    }

    public function toBroadcast($notifiable)
    {
         Log::info('📢 بث إشعار كورس جديد', [
        'channel' => 'students-channel',
        'course_id' => $this->course->id,
        'title' => $this->course->title,
    ]);
        return new BroadcastMessage([
            'course_id' => $this->course->id,
            'title' => $this->course->title,
            'image' => $this->course->image,
            'message' => "تمت إضافة كورس جديد: {$this->course->title} 🎉"
        ]);
    }

    public function broadcastOn()
    {
        Log::info('📡 الإشعار سيتبث على القناة: students-channel');
        return ['students-channel'];
    }
}
