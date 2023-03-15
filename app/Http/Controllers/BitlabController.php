<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BitlabController extends Controller
{
    public function index(Request $request)
    {
//        variable called api_token with the value of the api_token from the database column api_token
        $api_token = auth()->user()->api_token;

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects?per_page=250&access_token=' . $api_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $projects = json_decode($output, true);

        $projects = collect($projects);

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
        $privateKey = env('BITLAB_PRIVATE_KEY');

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '?access_token=' . $privateKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $project = json_decode($output, true);

        return view('projects.show', compact('project'));
    }

    public function activity()
    {
        $privateKey = env('BITLAB_PRIVATE_KEY');

        $url = 'https://bitlab.bit-academy.nl/api/v4/projects/' . request()->route('project') . '/events?access_token=' . $privateKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $activities = json_decode($output, true);

        return view('dashboard', compact('activities'));
    }

}

