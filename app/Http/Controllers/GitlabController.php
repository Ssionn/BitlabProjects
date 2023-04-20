<?php

namespace App\Http\Controllers;

use App\Events\IssueEvent;
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

    private function triggerNotificationForNewIssue($events, $api_token)
    {
        // Get the latest issue event from the events
        $latestIssueEvent = $events->where('target_type', 'issue')->first();

        // If there is no latest issue event, return
        if (!$latestIssueEvent) {
            return;
        }

        // Check if the latest issue event is already stored in cache
        $cachedLatestIssueEventId = Cache::get("latest_issue_event_id:$api_token");

        // If the latest issue event is not in cache or the event ID is different, trigger the event and update the cache
        if (!$cachedLatestIssueEventId || $latestIssueEvent['id'] !== $cachedLatestIssueEventId) {
            Cache::put("latest_issue_event_id:$api_token", $latestIssueEvent['id'], 60 * 5);

            event(new IssueEvent($latestIssueEvent));
        }
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
            $event['project_star_count'] = $project['star_count'] ?? 'N/A';
            $event['project_fork_count'] = $project['forks_count'] ?? 'N/A';

            return $event;
        });

        $this->triggerNotificationForNewIssue($events, $api_token);

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

        // everytime the api updates, find the newest Issue in the api and fire the event if a new issue is found



        return view('dashboard', [
            'events' => $events,
            'projects' => $projects,
        ]);
    }

    public function fetchGitClone()
    {
        $api_token = auth()->user()->api_token;
        $projectUrl = "https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=$api_token";

        $project = Cache::remember("projects:$api_token", 60 * 5, function () use ($projectUrl) {
            return Http::get($projectUrl)->collect();
        });

        return view('projects.clone', [
            'projects' => $project,
        ]);
    }
}
