<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="border-gray-700">
            <div class="flex p-2 text-sm rounded-lg text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" id="fix-alert" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Some features are not available at the moment:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        <li>Project Search doesn't work.</li>
                        <li>Sorting may be acting strange at times.</li>
                        <li>Working on a new Recent Activity UI.</li>
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700" data-dismiss-target="#fix-alert" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div x-data="syncComponent()" class="flex justify-end">
                <button @click.prevent="syncData" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded" :class="{ 'opacity-50': loading }" :disabled="loading">
                    <span x-show="!loading">Sync</span>
                    <div x-show="loading" class="flex flex-row items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Syncing...
                    </div>
                </button>
            </div>
            <div class="py-12">
                <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                    <section class="bg-gray-900 rounded-lg flex">
                        <div class="max-w-screen-xl px-4 mx-auto text-center lg:px-6">
                            <dl class="grid gap-8 mx-auto sm:grid-cols-2 text-white">
                                <div class="flex flex-col items-center justify-center bg-gray-800 p-12 sm:p-16 rounded-lg">
                                    <dt class="mb-2 text-3xl md:text-4xl font-extrabold">0</dt>
                                    <dd class="font-light text-gray-400">Events</dd>
                                </div>
                                <div class="flex flex-col items-center justify-center bg-gray-800 p-12 sm:p-16 rounded-lg">
                                    <dt class="mb-2 text-3xl md:text-4xl font-extrabold">0</dt>
                                    <dd class="font-light text-gray-400">Projects</dd>
                                </div>
                            </dl>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function syncComponent() {
            return {
                loading: false
                , syncData: function() {
                    var token = "{{ auth()->user()->api_token }}";
                    this.loading = true;
                    $.ajax({
                        url: '/dashboard/sync/status'
                        , type: 'get'
                        , data: {
                            access_token: token
                            , _token: "{{ csrf_token() }}"
                        , }
                        , success: (response) => {
                            toastr.success('Sync started. Please wait...');
                            this.startPolling();
                        }
                        , error: (error) => {
                            toastr.error('Something went wrong.');
                            toastr.options = {
                                "closeButton": true
                                , "progressBar": true
                                , "positionClass": "toast-bottom-right"
                                , "preventDuplicates": true
                                , "showDuration": "300"
                                , "hideDuration": "1000"
                                , "timeOut": "5000"
                                , "extendedTimeOut": "1000"
                            };
                            this.loading = false;
                        }
                    });
                }
                , startPolling: function() {
                    var poll = setInterval(() => {
                        $.ajax({
                            url: 'dashboard/sync/status'
                            , type: 'get'
                            , success: (response) => {
                                if (response.is_synced) {
                                    clearInterval(poll);
                                    this.loading = false;
                                    toastr.success('Sync completed successfully!');
                                }
                            }
                            , error: (error) => {
                                clearInterval(poll);
                                this.loading = false;
                                toastr.error('Something went wrong while checking sync status.');
                            }
                        });
                    }, 3000); // Check every 3 seconds
                }
            }
        }

    </script>
</x-app-layout>
