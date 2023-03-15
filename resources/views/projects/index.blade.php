<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    @if(auth()->user()->api_token)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-6">
                            <form method="GET" action="{{ route('projects.index') }}">
                                <label for="sort">Sort by:</label>
                                <select name="sort" id="sort" class="text-black" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }} >Latest
                                    </option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }} >Oldest
                                    </option>
                                </select>
                            </form>
                        </div>
                        <hr/>
                        @foreach($projects as $project)
                            @if($project['namespace']['name'] === auth()->user()->gitlab)
                                <div class="rounded-lg shadow-md p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="flex flex-col">
                                            <a href="{{ route('projects.show', $project['path']) }}">
                                                <h2 class="text-lg font-semibold ml-4">{{ ucwords(str_replace('-', ' ', preg_replace('/-[a-f0-9]{8}/', '', $project['name']))) }}</h2>
                                            </a>


                                            <p class="text-sm text-gray-500 ml-4">{{ $project['path'] }}</p>
                                        </div>
                                        @if ($project['star_count'] > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-6 w-6 text-yellow-400 ml-auto"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 3l2.966 6.643L19 7.215l-4.109 4.166.972 6.002L10 15.321 5.137 17.383l.972-6.002L1 7.215l6.034 2.428z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-gray-600">{{ $project['description'] }}</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <a href="{{ $project['web_url'] }}" target="_blank"
                                           class="inline-block px-4 py-2 text-white font-bold rounded-full bg-blue-500 hover:bg-blue-700 hover:underline">View
                                            on BitLab</a>
                                        <span class="text-gray-400">Last Updated: {{ date('M d, Y', strtotime($project['last_activity_at'])) }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="mt-5">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
