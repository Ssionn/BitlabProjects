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
//        variable called api_token with the value of the api_token from the database column api_token
        $api_token = auth()->user()->api_token;

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects?per_page=20&access_token=' . $api_token;

        $projects = Cache::remember("projects:$api_token", 60 * 5, function () use ($url) {
            return Http::get($url)->collect();
        });


        if ($request->query('sort') === 'oldest') {
            $projects = $projects->sortBy('created_at')->values();
        } else {
            $projects = $projects->sortByDesc('created_at')->values();
        }


        $perPage = 10;
        $page = request()->get('page') ?: 1;

        $array = $projects->toArray();
        $collection = collect($array);

        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage);

        $projects = new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('projects.index', compact('projects'));
    }

    public function show()
    {

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '?access_token=' . $privateKey;

        $projects = Http::get($url)->collect();

        return view('projects.show', compact('projects'));
    }

    public function activity()
    {
        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '/events?access_token=' . $privateKey;

        $activities = Http::get($url)->collect();

        return view('dashboard', compact('activities'));
    }

}

