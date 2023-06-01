<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class SearchProjects extends Component
{
    public $search;

    public $projects = [];

    public function updatedSearch()
    {
        $this->searchProjects();
    }

    public function searchProjects()
    {
        $response = Http::get('https://bitlab.bit-academy.nl/api/v4/projects?' . $this->search, [
            'per_page' => 250,
            'PRIVATE-TOKEN' => auth()->user()->gitlab_token,
        ]);

        // dd($response->json());

        $this->projects = $response->json();

    }

    public function render()
    {
        return view('livewire.search-projects');
    }
}
