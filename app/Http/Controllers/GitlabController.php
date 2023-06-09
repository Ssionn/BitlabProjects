<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCommit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class GitlabController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve only the projects for the logged in user
        $projects = Project::all();
        $projectCommit = ProjectCommit::all();

        foreach ($projects as $project) {
            $project->commit_count = $projectCommit->where('project_id', $project->id)->count();
        }

        if ($request->query('sort') == 'oldest') {
            $projects = $projects->sortByDesc(function ($item) {
                return strtotime($item['created_at']);
            });
        } elseif ($request->query('sort') == 'latest') {
            $projects = $projects->sortBy(function ($item) {
                return strtotime($item['created_at']);
            });
        }

        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $currentPageItems = $projects->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $projects = new LengthAwarePaginator($currentPageItems, $projects->count(), $perPage, $currentPage, ['path' => Paginator::resolveCurrentPath()]);

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function getUserActivity()
    {
        $project = Project::all();

        $userId = auth()->user()->id;

        $cacheKey = 'events_'.$userId;

        if (Cache::has($cacheKey)) {
            $events = Cache::get($cacheKey);
        } else {
            $events = auth()->user()->gitlab()->getEvents();
            Cache::put($cacheKey, $events, now()->addMinutes(5));
        }

        // Convert events array to collection
        $events = collect($events);

        $events = $events->map(function ($event) use ($project) {
            $associatedProject = $project->firstWhere('id', $event['project_id'] ?? null);

            if ($associatedProject) {
                $event['project_name_with_namespace'] = $associatedProject['name_with_namespace'] ?? null;
                $event['project_branch'] = $associatedProject['default_branch'] ?? null;
                $event['project_web_url'] = $associatedProject['web_url'] ?? null;
                $event['project_star_count'] = $associatedProject['star_count'] ?? null;
                $event['project_forks_count'] = $associatedProject['forks_count'] ?? null;
            }

            return $event;
        });

        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $currentPageItems = $events->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $events = new LengthAwarePaginator($currentPageItems, $events->count(), $perPage, $currentPage, ['path' => Paginator::resolveCurrentPath()]);

        return view('activity', [
            'events' => $events,
            'projects' => $project,
        ]);
    }

    // public function fetchGitClone()
    // {
    //     $project = auth()->user()->gitlab()->getProjects();

    //     return view('projects.clone', [
    //         'projects' => $project,
    //     ]);
    // }

    // public function search(Request $request)
    // {
        // function goes here with site-wide search and autocomplete
    // }
}
