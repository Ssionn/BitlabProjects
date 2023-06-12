<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectBranches;
use App\Models\ProjectCommit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class GitlabController extends Controller
{
    public function index(Request $request)
    {

        $projects = Project::all();
        $projectCommit = ProjectCommit::all();

        foreach ($projects as $project) {
           $project->commit_count = $projectCommit->where('project_id', $project->commit_count)->count();
        }

        if ($request->query('sort') == 'oldest') {
            $projects = $projects->sortBy(function ($item) {
                return strtotime($item['created_at']);
            });
        } elseif ($request->query('sort') == 'latest') {
            $projects = $projects->sortByDesc(function ($item) {
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

        $event = collect(auth()->user()->gitlab()->getEvents());

        $event = Cache::remember('events', 60, function () use ($event) {
            return $event;
        });

        $event = $event->map(function ($event) use ($project) {
            $associatedProject = $project->firstWhere('id', $event['project_id']);

            if ($associatedProject) {
                $event['project_name_with_namespace'] = $associatedProject['name_with_namespace'];
                $event['project_branch'] = $associatedProject['default_branch'];
                $event['project_web_url'] = $associatedProject['web_url'];
                $event['project_star_count'] = $associatedProject['star_count'];
                $event['project_forks_count'] = $associatedProject['forks_count'];
            }

            return $event;
        });

        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $currentPageItems = $event->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $event = new LengthAwarePaginator($currentPageItems, $event->count(), $perPage, $currentPage, ['path' => Paginator::resolveCurrentPath()]);

        return view('dashboard', [
            'events' => $event,
            'projects' => $project,
        ]);
    }

    public function fetchGitClone()
    {
        $project = auth()->user()->gitlab()->getProjects();

        return view('projects.clone', [
            'projects' => $project,
        ]);
    }

    public function search(Request $request)
    {
        // function goes here with site-wide search and autocomplete
    }
}
