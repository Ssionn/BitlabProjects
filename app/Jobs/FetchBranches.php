<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\ProjectBranches;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchBranches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $projects = $user->gitlab()->getProjects();

        foreach ($projects as $projectData) {
            $project = Project::firstOrCreate(
                ['project_id' => $projectData['id']],
                ['name' => $projectData['name']]
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
