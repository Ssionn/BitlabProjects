<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchEvent;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class DispatchFetchEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:fetch {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches events for all projects';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userId = $this->argument('userId');
        $user = User::findOrFail($userId);

        $job = new FetchEvent($user->api_token);

        $batch = Bus::batch([$job])->dispatch();

        $this->info('Batch ID: '.$batch->id.' has been dispatched!');
    }
}
