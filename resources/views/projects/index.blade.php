<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <script>
        $(function() {
            var projects = [
                @foreach($projects as $project)
                "{{ $project['name'] }}"
                , @endforeach
            ];

            $("#search").autocomplete({
                source: projects
            });
        })

    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex flex-row justify-between">
                        <div class="md:mb-6 md:ml-6 mb-4 ml-4">
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
                        <div class="sm:mr-2 invisible sm:visible">
                            <form method="GET" action="{{ route('projects.index') }}">
                                <input type="text" name="search" id="search" placeholder="Search" class="rounded-lg bg-gray-700">
                            </form>
                        </div>
                    </div>
                    <hr />
                    {{-- responsive ui --}}
                    <div class="flex flex-col md:ml-3">
                        @foreach($projects as $project)
                        <div class="flex sm:flex-row flex-col justify-between border-b border-spacing-1 mt-2 md:pl-3 md:mr-2">
                            <div class="mb- md:mb-5 text-center md:text-start">
                                <button data-popover-target="popover-name" type="button">
                                    <h1 class="mt-2"><strong>{{ ucfirst($project['name']) }}</strong></h1>
                                </button>
                                <div data-popover id="popover-name" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm transition-opacity duration-300 border rounded-lg shadow-sm opacity-0 text-gray-400 border-gray-600 bg-gray-800">
                                    <div class="px-3 py-2 border-b rounded-t-lg border-gray-600 bg-gray-700">
                                        <h3 class="font-semibold text-white">Repository Stats:</h3>
                                    </div>
                                    <div class="px-3 py-2 border-b border-gray-600">
                                        <p>Commits: {{ $project['commits'] }}</p>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Branches: {{ $project['branches'] }}</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                                <h3 class="text-sm text-gray-400">{{ $project['path'] }}</h3>
                                <div class="mt-8">
                                    <a href="{{ $project['web_url'] }}" target="_blank">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white text-white focus:ring-4 focus:outline-none focus:ring-blue-800">
                                            <span class="relative px-5 py-1.5 transition-all ease-in duration-75 bg-gray-700 rounded-md group-hover:bg-opacity-0">
                                                View on Bitlab
                                            </span>
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row items-center md:items-baseline mb-2">
                                <div class="text-sm text-gray-300 md:flex-grow mr-2 md:mr-0 md:mt-3 mt-3">
                                    {{ \Carbon\Carbon::parse($project['created_at'])->format('d M Y')}}
                                    at:
                                    {{ \Carbon\Carbon::parse($project['created_at'])->format('H:i') }}
                                    <div class="flex flex-row items-center justify-center space-x-2 md:mt-1">
                                        <div class="text-gray-300 space-x-2 md:flex">
                                            <span><i class="fa-regular fa-star"></i> {{ $project['star_count'] }}</span>
                                            <span><i class="fa-regular fa-code-fork"></i> {{ $project['forks_count'] }}</span>
                                        </div>

                                        <button type="button" data-popover-target="popover-default" data-copy-button data-project-id="{{ $project['id'] }}" type="button" class="hidden text-purple-600 border border-purple-600 hover:bg-purple-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center md:inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                                            <i class='fa fa-clone'></i>
                                        </button>

                                        <div data-popover id="popover-default" role="tooltip" class="absolute z-10 invisible inline-block w-42 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                            <div class="px-3 py-2 bg-gray-100 border-b rounded-lg border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                <h3 class="font-semibold text-gray-900 dark:text-white text-center">Copy to clipboard</h3>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="mt-4">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
