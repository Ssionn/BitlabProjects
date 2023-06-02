<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\ProjectBranches;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchBranch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $accessToken;

    public $timeout = 300;

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

        $projects = Project::all();

        foreach ($projects as $projectData) {
            $project = Project::firstOrCreate(
                ['bitlab_id' => $projectData['id']],
                ['name' => $projectData['name'],
                    'path' => $projectData['path'],
                    'web_url' => $projectData['web_url'],
                    'ssh_url_to_repo' => $projectData['ssh_url_to_repo'],
                    'star_count' => $projectData['star_count'],
                    'forks_count' => $projectData['forks_count'],
                    'last_activity_at' => $projectData['last_activity_at']],
            );

            $branches = $user->gitlab()->getBranches($projectData['id']);

            foreach ($branches as $branch) {
                ProjectBranches::firstOrCreate([
                    'project_id' => $project->project_id,
                    'branch' => $branch['name'],
                ]);
            }
        }
    }
}
