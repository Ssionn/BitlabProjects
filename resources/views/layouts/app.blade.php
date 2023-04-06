<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Bitlab Projects Dashboard is a web application that provides an easy-to-use interface for managing and tracking your projects on Bitlab. The dashboard offers a comprehensive view of your repositories, including recent activity, commits, issues, and merge requests. It also features a notification system to keep you informed of important updates.">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=exo:400" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        const pusher = new Pusher('63407304687533ec8588', {
            cluster: 'eu'
        });

        const channel = pusher.subscribe('commit-repository-channel');
        channel.bind('new-commit-repository', function(data) {
            toastr.info('New commit on repository: ' + {
                !!json_encode($projects['name_with_namespace']) !!
            } + ' by ' + {
                !!json_encode($projects['namespace']['name']) !!
            } + ' (Branch: ' + {
                !!json_encode($events['push_data']['ref']) !!
            } + ')', 'New commit', {
                "closeButton": true
                , "debug": false
                , "newestOnTop": false
                , "progressBar": false
                , "positionClass": "toast-bottom-right"
                , "preventDuplicates": false
                , "onclick": null
                , "showDuration": "86400000"
                , "hideDuration": "86400000"
                , "timeOut": "86400000"
                , "extendedTimeOut": "86400000"
                , "showEasing": "swing"
                , "hideEasing": "linear"
                , "showMethod": "fadeIn"
                , "hideMethod": "fadeOut"
            });
        });

    </script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-scree bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>

</body>
</html>
