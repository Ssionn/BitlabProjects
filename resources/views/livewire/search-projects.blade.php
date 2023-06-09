<div class="mr-12 flex mt-2">
    <div class="flex items-center">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="flex flex-col">
            <div class="flex flex-row">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.debounce.500ms="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
                </div>
            </div>
            @if(!empty($search))
            <div class="flex flex-col justify-start rounded-md mt-1 pl-2 space-y-1 pb-2 pt-2 bg-white">
                @foreach($projects as $project)
                <p>{{ $project['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
