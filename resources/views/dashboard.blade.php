<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h1 class="text-2xl font-bold mb-4 text-center md:text-start">Most recent activity</h1>
                    <div class="bg-gray-800 shadow-md rounded p-6">
                        @if (count($events) == 0)
                        <div class="text-center">
                            <h1 class="text-2xl font-bold text-center md:text-start">No activity</h1>
                        </div>
                        @else
                        @foreach ($events as $event)
                        <div class="border-b border-spacing-1 pb-4 mb-4">
                            <div class="flex flex-col md:flex-row items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="md:ml-3">
                                        <div class="font-semibold">
                                            {{ $event['author']['name'] ?? 'Unknown' }}
                                            ({{ $event['author']['username'] ?? 'Unknown' }})
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex md:flex-row flex-col">
                                                @if($event['push_data']['ref_type'] ?? null)
                                                {{ ucfirst($event['action_name']) }}
                                                {{ $event['push_data']['ref_type'] ?? null }}:
                                                &nbsp
                                                <a href="{{ $event['project_web_url'] . '/tree/' . $event['push_data']['ref'] ?? null }}" target="_blank" class="underline">
                                                    {{ $event['push_data']['ref'] ?? null }}
                                                </a>
                                                @else
                                                {{ ucfirst($event['action_name']) }}:
                                                @endif
                                            </div>
                                            <div class="mt-2">
                                                <a href="{{ $event['project_web_url'] }}" target="_blank" class="underline">
                                                    {{ $event['project_name_with_namespace'] ?? null }}
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                @if($event['push_data']['commit_to'] ?? null)
                                                {{ substr($event['push_data']['commit_to'] ?? null, 0, 8) }}
                                                · {{ $event['push_data']['commit_title'] ?? null }}
                                                @elseif($event['target_type'] ?? null)
                                                @if($event['target_type'] == 'MergeRequest')
                                                {{ preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $event['target_type'] ?? '') }} ·
                                                <a href="{{ $event['project_web_url'] . '/-/merge_requests/' . $event['target_iid'] }}" target="_blank" class="underline">
                                                    {{ $event['target_title'] ?? null }}
                                                </a>
                                                @elseif($event['target_type'] == 'Issue')
                                                {{ preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $event['target_type'] ?? '') }} ·
                                                <a href="{{ $event['project_web_url'] . '/-/issues/' . $event['target_iid'] }}" target="_blank" class="underline">
                                                    {{ $event['target_title'] ?? null }}
                                                </a>
                                                @endif
                                                @else
                                                {{ substr($event['push_data']['commit_to'] ?? 'N/a', 0, 8) }}
                                                · {{ $event['push_data']['commit_title'] ?? 'N/a' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center w-full md:w-auto">
                                    <div class="flex flex-row items-center justify-center md:justify-start md:flex-col mt-4 md:mt-2">
                                        <div class="text-sm text-gray-300 flex-grow mr-2 md:mr-0">{{ \Carbon\Carbon::parse($event['created_at'])->format('d M Y') }}
                                            at {{ \Carbon\Carbon::parse($event['created_at'])->format('H:i') }}
                                        </div>
                                        <div class="text-gray-300 space-x-2 flex md:justify-end md:mt-2">
                                            <span><i class="fa-regular fa-star"></i> {{ $event['project_star_count'] }}</span>
                                            <span><i class="fa-regular fa-code-fork"></i> {{ $event['project_fork_count'] }}</span>
                                        </div>
                                    </div>
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
</x-app-layout>
