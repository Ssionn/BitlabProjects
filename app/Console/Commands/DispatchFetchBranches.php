<?php

namespace App\Console\Commands;

use App\Jobs\FetchBranches;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class DispatchFetchBranches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branches:fetch {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches branches for all projects';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userId = $this->argument('userId');
        $user = User::findOrFail($userId);

        $job = new FetchBranches($user->api_token);

        $batch = Bus::batch([$job])->dispatch();

        $this->info('Batch ID: '.$batch->id.' has been dispatched!');
    }
}
