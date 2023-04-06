<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IssueEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $issue;
    public $repository;
    /**
     * Create a new event instance.
     */
    public function __construct($issue, $repository)
    {
        $this->issue = $issue;
        $this->repository = $repository;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('issue-repository-channel'),
        ];
    }

    public function broadcastAs()
    {
        return 'new-issue-repository';
    }
}
