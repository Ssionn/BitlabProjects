<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GitlabRepository
{
    public function __construct(public string $apiToken)
    {
        //
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
        $allProjects = [];

        do {
            $response = $this->makeClient()
                ->get('https://bitlab.bit-academy.nl/api/v4/projects/', [
                    'per_page' => '20',
                    'simple' => 'true',
                    'page' => $page,
                ]);

            $projects = $response->json();
            $allProjects = array_merge($allProjects, $projects);

            $page++;
        } while (! empty($projects));

        return $allProjects;
    }

    public function getEvents()
    {
        $page = 1;
        $allEvents = [];
        while (true) {
            $response = $this->makeClient()
                ->get('https://bitlab.bit-academy.nl/api/v4/events', [
                    'per_page' => 20,
                    'simple' => 'true',
                    'page' => $page,
                ]);

            $events = $response->json();

            if (empty($events)) {
                break;
            }

            $allEvents = array_merge($allEvents, $events);
            $page++;
        }

        return $allEvents;
    }

    public function getCommits(string $projectId)
    {
        $page = 1;
        $allCommits = [];
        while (true) {
            $response = $this->makeClient()
                ->get('https://bitlab.bit-academy.nl/api/v4/projects/'.$projectId.'/repository/commits', [
                    'per_page' => 20,
                    'simple' => 'true',
                    'page' => $page,
                ]);

            $commits = $response->json();

            // If there are no more commits, break out of the loop
            if (empty($commits)) {
                break;
            }

            // Merge the commits from the current page into the allCommits array
            $allCommits = array_merge($allCommits, $commits);
            $page++;
        }

        return $allCommits;
    }

    public function getBranches(string $projectId)
    {
        $page = 1;
        $allBranches = [];
        while (true) {
            $response = $this->makeClient()
                ->get('https://bitlab.bit-academy.nl/api/v4/projects/'.$projectId.'/repository/branches', [
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
