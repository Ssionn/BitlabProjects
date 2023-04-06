<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h1 class="text-2xl font-bold mb-4 ">Most recent activity</h1>
                    <div class="bg-gray-800 shadow-md rounded p-6">
                        @if (count($events) == 0)
                        <div class="text-center">
                            <h1 class="text-2xl font-bold">No activity</h1>
                        </div>
                        @else
                        @foreach ($events as $event)
                        <div class="border-b border-spacing-1 pb-4 mb-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="ml-3">
                                        <div class="font-semibold">
                                            {{ $event['author']['name'] ?? 'Unknown' }}
                                            ({{ $event['author']['username'] ?? 'Unknown' }})
                                        </div>
                                        <div class="mt-2">
                                            @if ($event['is_private_contribution'])
                                            <div class="flex flex-row items-center">
                                                <i class='fa fa-lock'></i>
                                                Made a private contribution
                                            </div>
                                            @elseif (isset($event['push_data']))
                                            <div class="flex flex-row items-center">
                                                <i class='fas fa-code-branch'></i>
                                                &nbsp
                                                Pushed to branch:
                                                &nbsp
                                                <a href="{{ $event['project_web_url'] . '/-/tree/' . $event['push_data']['ref'] }}" target="_blank" class="underline">
                                                    {{ $event['push_data']['ref'] }}
                                                </a>
                                            </div>
                                            <div>at:
                                                <a href="{{ $event['project_web_url'] }}" target="_blank" class="underline">
                                                    {{ $event['project_name_with_namespace'] }}
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{ $event['project_web_url'] . '/-/commit/' . $event['push_data']['commit_to'] }}" target="_blank" class="underline">
                                                    {{ substr($event['push_data']['commit_to'], 0, 8) }}
                                                </a>
                                                · {{ $event['push_data']['commit_title'] }}</div>
                                            @elseif ($event['action_name'] == 'joined')
                                            <div class="flex flex-row items-center">
                                                <i class='fas fa-people-arrows'></i>
                                                &nbsp
                                                Joined project: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @elseif ($event['action_name'] == 'created')
                                            <div class="flex flex-row items-center">
                                                <i class="fa-solid fa-globe"></i>
                                                &nbsp
                                                Created project: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @elseif ($event['action_name'] == 'deleted')
                                            <div class="flex flex-row items-center">
                                                <i class="fa fa-trash"></i>
                                                &nbsp
                                                Deleted project: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @elseif ($event['action_name'] == 'accepted')
                                            <div class="flex flex-row items-center">
                                                <i class="fa-regular fa-code-merge"></i>
                                                &nbsp
                                                Merged project: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @elseif ($event['action_name'] == 'opened')
                                            <div class="flex flex-row items-center">
                                                <i class="fa-regular fa-folder-open"></i>
                                                &nbsp
                                                Opened project: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @elseif ($event['action_name'] == 'commented on')
                                            <div class="flex flex-row items-center">
                                                <i class='fa-solid fa-message'></i>
                                                &nbsp
                                                Commented on: {{ $event['project_name_with_namespace'] }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($event['created_at'])->format('d M Y') }}
                                    at {{ \Carbon\Carbon::parse($event['created_at'])->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ $events->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
