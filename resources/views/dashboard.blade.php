<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-4xl font-bold mb-4 ">Most recent activity</h1>

                    <div class="bg-white dark:bg-gray-800 shadow-md rounded p-6">
                        @foreach ($events as $event)
                            <div class="border-b pb-4 mb-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
{{--                                        <img src="{{  }}"--}}
{{--                                             alt="{{ $event['author']['name'] }}"--}}
{{--                                             class="w-12 h-12 rounded-full">--}}
                                        <div class="ml-3">
                                            <div class="font-semibold">{{ $event['author']['name'] }}
                                                ({{ $event['author']['username'] }})
                                            </div>
                                            <div class="ml-16 mt-2">
                                                @if($event['push_data'] ?? false)
                                                    <div>Pushed to branch: {{ $event['push_data']['ref'] }}</div>
                                                    @php
                                                        $projectNamespace = 'N/A';
                                                    @endphp

                                                    @foreach ($projects as $project)
                                                        @if ($project['id'] === $event['project_id'])
                                                            @php
                                                                $projectNamespace = $project['name_with_namespace'];
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <div>at: {{ $projectNamespace }}</div>
                                                    <div>{{ substr($event['push_data']['commit_to'], 0, 8) }}
                                                        · {{ $event['push_data']['commit_title'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event['created_at'])->format('d M Y') }}
                                        at {{ \Carbon\Carbon::parse($event['created_at'])->format('H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
