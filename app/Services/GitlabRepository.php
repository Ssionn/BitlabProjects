<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GitlabRepository
{
    public function __construct(public string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    protected function makeClient()
    {
        return Http::withHeaders([
            'PRIVATE-TOKEN' => $this->apiToken,
        ]);
    }

    public function getProjects()
    {
        $page = 1;
        $response = $this->makeClient()
            ->get('https://bitlab.bit-academy.nl/api/v4/projects?', [
                'per_page' => 100,
                'simple' => 'true',
                'page' => $page,
            ]);
        $projects = $response->json();

        return $projects;
    }

    public function getEvents()
    {
        $page = 1;
        $response = $this->makeClient()
            ->get('https://bitlab.bit-academy.nl/api/v4/events?', [
                'per_page' => 100,
                'simple' => 'true',
                'page' => $page,
            ]);

        $events = $response->json();

        return $events;
    }

    public function getCommits(string $projectId)
    {
        $page = 1;
        $response = $this->makeClient()
            ->get('https://bitlab.bit-academy.nl/api/v4/projects/'.$projectId.'/repository/commits', [
                'per_page' => 100,
                'simple' => 'true',
                'page' => $page,
            ]);

        $commits = $response->json();
        return $commits;
    }

    public function getBranches(string $projectId)
    {
        $page = 1;
        $allBranches = [];
        while (true) {
            $response = $this->makeClient()
                ->get('https://bitlab.bit-academy.nl/api/v4/projects/'.$projectId.'/repository/branches?', [
                    'per_page' => 100,
                    'simple' => 'true',
                    'page' => $page,
                ]);

            $branches = $response->json();

            // If there are no more commits, break out of the loop
            if (empty($branches)) {
                break;
            }

            // Merge the commits from the current page into the allCommits array
            $allBranches = array_merge($allBranches, $branches);
            $page++;
        }

        return $allBranches;
    }
}
