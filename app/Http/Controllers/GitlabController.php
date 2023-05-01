<?php

namespace App\Http\Controllers;

use App\Events\IssueEvent;
use App\Events\NewIssueEvent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class GitlabController extends Controller
{
    private function authToken()
    {
        $api_token = auth()->user()->api_token;

        return $api_token;
    }

    public function index(Request $request, $projectId)
    {
        $api_token = $this->authToken();

        $projectUrl = "https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=100&access_token=$api_token";
        $eventUrl = "https://bitlab.bit-academy.nl/api/v4/events?simple=true&per_page=100&access_token=$api_token";
        $commitUrl = "https://bitlab.bit-academy.nl/api/v4/projects/$projectId/repository/commits?per_page=100&access_token=$api_token";

        $projects = Cache::remember("projects:$api_token", 60 * 5, function () use ($projectUrl) {
            return Http::get($projectUrl)->collect();
        });

        $events = Cache::remember("events:$api_token", 60 * 5, function () use ($eventUrl) {
            return Http::get($eventUrl)->collect();
        });

        $commits = Cache::remember("commits:$api_token", 60 * 5, function () use ($commitUrl) {
            return Http::get($commitUrl)->collect();
        });

        if ($request->query('sort') === 'oldest') {
            $projects = $projects
                ->sortBy('created_at')
                ->values();
        } else {
            $projects = $projects
                ->sortByDesc('created_at')
                ->values();
        }

        if ($request->query('search')) {
            $projects = $projects->filter(function ($project) use ($request) {
                return str_contains($project['name'], $request->query('search'));
            });
        }

        $page = $request->query('page', 1);
        $perPage = 10;
        $offset = ($perPage * $page) - $perPage;

        $projects = new LengthAwarePaginator(
            $projects->slice($offset, $perPage),
            $projects->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        return view('projects.index', [
            'projects' => $projects,
            'events' => $events,
            'commits' => $commits,
        ]);
    }

    public function getUserActivity(Request $request)
    {
        $api_token = $this->authToken();

        $url = 'https://bitlab.bit-academy.nl/api/v4/events?per_page=250&access_token=' . $api_token;
        $projectUrl = 'https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=' . $api_token;

        $events = Cache::remember("events:$api_token", 60 * 5, function () use ($url) {
            return Http::get($url)->collect();
        });

        $projects = Cache::remember("projects:$api_token", 60 * 5, function () use ($projectUrl) {
            return Http::get($projectUrl)->collect();
        });

        $events = $events->map(function ($event) use ($projects) {
            $project = $projects->firstWhere('id', $event['project_id']);
            $event['project_name_with_namespace'] = $project['name_with_namespace'] ?? 'N/A';
            $event['project_branch'] = $project['default_branch'] ?? 'N/A';
            $event['project_web_url'] = $project['web_url'] ?? 'N/A';
            $event['project_star_count'] = $project['star_count'] ?? 'N/A';
            $event['project_fork_count'] = $project['forks_count'] ?? 'N/A';

            return $event;
        });


        // pagination
        $page = $request->query('page', 1);
        $perPage = 10;
        $offset = ($perPage * $page) - $perPage;

        $events = new LengthAwarePaginator(
            $events->slice($offset, $perPage),
            $events->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard', [
            'events' => $events,
            'projects' => $projects,
        ]);
    }

    public function fetchGitClone()
    {
        $api_token = $this->authToken();
        $projectUrl = "https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=$api_token";

        $project = Cache::remember("projects:$api_token", 60 * 5, function () use ($projectUrl) {
            return Http::get($projectUrl)->collect();
        });

        return view('projects.clone', [
            'projects' => $project,
        ]);
    }
}
