<?php

namespace App\Listeners;

use App\Jobs\FetchCommit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FetchUserProjects
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Dispatch the FetchCommit job for the new user
        $job = new FetchCommit($event->user->api_token);
        $batch = Batch::dispatch([$job]);

        info('Batch ID: '.$batch->id.' has been dispatched for new user!');
    }
}

