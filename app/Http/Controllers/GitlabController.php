<?php

namespace App\Http\Controllers;

use App\Events\CommitEvent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class GitlabController extends Controller
{
    public function index(Request $request)
    {
        $api_token = auth()->user()->api_token;

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=' . $api_token;

        $projects = Cache::remember("projects:$api_token", 60 * 5, function () use ($url) {
            return Http::get($url)->collect();
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
        ]);
    }

    public function show()
    {

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '?simple=true&access_token=' . auth()->user()->api_token;

        $projects = Http::get($url)->collect();

        return view('projects.show', [
            'projects' => $projects,
        ]);
    }

    public function getUserActivity(Request $request)
    {
        $api_token = auth()->user()->api_token;

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

    // public function getMergeRequestRelatedToIssue($project_id, $issue_id)
    // {
    //     $api_token = auth()->user()->api_token;
    //     $mergeRequestUrl = "https://bitlab.bit-academy.nl/api/v4/projects/$project_id/issues/$issue_id/related_merge_requests?simple=true&per_page=250&access_token=$api_token";

    //     $mergeRequests = Http::get($mergeRequestUrl)->collect();

    //     return Redirect::to($mergeRequests[0]['web_url']);
    // }

    public function fetchGitClone()
    {
        $projectsUrl = 'https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=' . auth()->user()->api_token;

        $projects = Http::get($projectsUrl)->collect();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }


}
