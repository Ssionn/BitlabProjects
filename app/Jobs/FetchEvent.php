<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $accessToken;

    public $timeout = 600;
    /**
     * Create a new job instance.
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('api_token', $this->accessToken)->first();

        if (! $user) {
            Log::error('User not found with provided access token');

            return;
        }

        $events = $user->gitlab()->getEvents();
        $projects = $user->gitlab()->getProjects();

        foreach($events as $event) {
            $events = Event::firstOrCreate(
                ['project_id' => Project::where],
                ['name' => $event['name'],
                'username' => $event['username'],
                'ref' => $event['ref'],
                'ref_type' => $event['ref_type'],
                'action_name' => $event['action_name'],
                'commit_to' => $event['commit_to'],
                'commit_title' => $event['commit_title'],
                'target_type' => $event['target_type'],
                'target_title' => $event['target_title'],
                'target_iid' => $event['target_iid'],
                'project_web_url' => $projects['web_url'],
                'project_name_with_namespace' => $projects['name_with_namespace'],
                'project_branch' => $projects['default_branch'],
                'project_star_count' => $projects['star_count'],
                'project_forks_count' => $projects['forks_count'],
                'last_activity_at' => $event['last_activity_at']]
            );
        }
    }
}
