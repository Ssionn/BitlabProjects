<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRepositoryNotification extends Notification
{
    use Queueable;

    protected $repository;

    /**
     * Create a new notification instance.
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
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
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'repository_id' => $this->repository->id,
            'repository_name' => $this->repository->name,
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
            'repository_id' => $this->repository->id,
            'repository_name' => $this->repository->name,
            'user_id' => $notifiable->id,
        ];
    }
}
