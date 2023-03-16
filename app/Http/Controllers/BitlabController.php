<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class BitlabController extends Controller
{
    public function index(Request $request)
    {
        $api_token = auth()->user()->api_token;

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=100&access_token=' . $api_token;
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

        return view('projects.index', compact('projects'));
    }

    public function show()
    {

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '?simple=true&access_token=' . auth()->user()->api_token;

        $projects = Http::get($url)->collect();

        return view('projects.show', compact('projects'));
    }

    public function getUserActivity(Request $request)
    {
        $url = 'https://bitlab.bit-academy.nl/api/v4/users/' . auth()->user()->gitlab . '/events?per_page=250&access_token=' . auth()->user()->api_token;

        $projectUrl = 'https://bitlab.bit-academy.nl/api/v4/projects?simple=true&per_page=250&access_token=' . auth()->user()->api_token;

        $events = Http::get($url)->collect();

        $projects = Http::get($projectUrl)->collect();

        $events = $events->map(function ($event) use ($projects) {
            $project = $projects->firstWhere('id', $event['project_id']);
            $event['project_name_with_namespace'] = $project['name_with_namespace'] ?? 'N/A';
            $event['is_private_contribution'] = isset($project['visibility']) && $project['visibility'] === 'private';

            return $event;
        });

        $page = $request->query('page', 1);
        $perPage = 25;
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

//    public function fetchGitlabId()
//    {
//        $url = 'https://bitlab.bit-academy.nl/api/v4/users?username=' . auth()->user()->gitlab . '&access_token=' . auth()->user()->api_token;
//
//        $gitlabId = Http::get($url)->collect();
//
//
//    }


}

