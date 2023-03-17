<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommitNotification extends Notification
{
    use Queueable;

    protected $commit;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct($commit)
    {
        $this->commit = $commit;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'commit_id' => $this->commit->id,
            'commit_message' => $this->commit->message,
            'user_id' => $notifiable->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'commit_id' => $this->commit->id,
            'commit_message' => $this->commit->message,
            'user_id' => $notifiable->id,
        ];
    }
}
