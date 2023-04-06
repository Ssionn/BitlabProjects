<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommitEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $repository;
    public $commit;

    public function __construct($repository, $commit)
    {
        $this->repository = $repository;
        $this->commit = $commit;
    }

    public function broadcastOn()
    {
        return new Channel('commit-repository-channel');
    }

    public function broadcastAs()
    {
        return 'new-commit-repository';
    }
}
