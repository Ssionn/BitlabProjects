<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchCommit;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class FetchAllUsersCommits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commits:fetch:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch commits for all users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Fetch all users
        $users = User::all();

        $jobs = [];

        // Prepare jobs for all users
        foreach ($users as $user) {
            $jobs[] = new FetchCommit($user->api_token);
        }

        // Dispatch all jobs in a batch
        $batch = Bus::batch($jobs)->dispatch();

        $this->info('Batch ID: '.$batch->id.' has been dispatched!');
    }
}
