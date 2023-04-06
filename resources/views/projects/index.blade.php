<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    @if(auth()->user()->api_token)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="mb-6">
                        <form method="GET" action="{{ route('projects.index') }}">
                            <label for="sort">Sort by:</label>
                            <select name="sort" id="sort" class="text-black" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest
                                </option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest
                                </option>
                            </select>
                        </form>
                    </div>
                    <hr />
                    @foreach($projects as $project)
                    @if($project['namespace']['name'] === auth()->user()->gitlab)
                    <div class="rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex flex-col">
                                <a href="{{ route('projects.show', $project['path']) }}">
                                    <h2 class="text-lg font-semibold ml-4">{{ ucwords(str_replace('-', ' ', preg_replace('/-[a-f0-9]{8}/', '', $project['name']))) }}</h2>
                                </a>
                                <p class="text-sm text-gray-500 ml-4">{{ $project['path'] }}</p>
                            </div>
                            <div class="flex flex-row">


                                <button data-popover-target="popover-default" data-copy-button data-project-id="{{ $project['id'] }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><i class="fas fa-copy"></i></button>

                                <div data-popover id="popover-default" role="tooltip" class="absolute z-10 invisible inline-block w-48 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b rounded-lg border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white text-center">Copy Git Clone URL</h3>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <input type="text" id="cloneUrl-{{ $project['id'] }}" value="{{ $project['ssh_url_to_repo'] }}" style="display: none;" />
                                <div class="flex flex-col items-center ml-3">
                                    <span><i class="fa-regular fa-star"></i> {{ $project['stars_count'] }}</span>
                                    <span><i class="fa-regular fa-code-fork"></i> {{ $project['forks_count'] }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $project['description'] }}</p>
                        <div class="mt-4 ml-4 flex justify-between items-center">
                            <a href="{{ $project['web_url'] }}" target="_blank" class="inline-block px-4 py-2 text-white font-bold rounded-md bg-blue-500 hover:bg-blue-700 hover:underline">View
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
    <script>
        document.querySelectorAll('[data-copy-button]').forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.dataset.projectId;
                const cloneUrl = document.getElementById(`cloneUrl-${projectId}`);
                cloneUrl.style.display = 'block';
                cloneUrl.select();
                document.execCommand('copy');
                cloneUrl.style.display = 'none';
                alert('Copied to clipboard');
            });
        });

    </script>

</x-app-layout>
