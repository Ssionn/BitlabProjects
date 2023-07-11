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

        // put user_id in the project table

        $projects = $user->gitlab()->getProjects();

        foreach ($projects as $projectData) {
            // dd($projectData);
            $project = Project::firstOrCreate(
                ['project_id' => $projectData['id']],
                ['name' => $projectData['name'],
                    'path' => $projectData['path'],
                    'web_url' => $projectData['web_url'],
                    'ssh_url_to_repo' => $projectData['ssh_url_to_repo'],
                    'star_count' => $projectData['star_count'],
                    'forks_count' => $projectData['forks_count'],
                    'last_activity_at' => $projectData['last_activity_at']]
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
