<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\ProjectCommit;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCommit implements ShouldQueue
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

        $projects = $user->gitlab()->getProjects();

        foreach ($projects as $projectData) {
            // firstOrCreate will try to find a project with the given project_id or create a new one
            $project = Project::firstOrCreate(
                ['project_id' => $projectData['id']],
                ['name' => $projectData['name']]
            );

            $commits = $user->gitlab()->getCommits($projectData['id']);

            foreach ($commits as $commit) {
                ProjectCommit::firstOrCreate([
                    'project_id' => $project->project_id,
                    'commit_sha' => $commit['id'],
                ]);
            }
        }
    }
}
