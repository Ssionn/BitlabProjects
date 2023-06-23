<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="BitlabProjects is a web application that provides an easy-to-use interface for managing and tracking your projects on Bitlab. The dashboard offers a comprehensive view of your repositories, including recent activity, commits, issues, and merge requests. It also features a notification system to keep you informed of important updates.">
    <title>BitlabProjects | Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-900">

    {{-- Temporary Alert --}}

        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-gray-800 shadow">
            <div class="max-w-6xl [1920px]:max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>


        <script>
            // Feature Alert
            document.getElementById('fix-alert').addEventListener('click', function() {
                localStorage.setItem('fix-alert', 'true');
            });
            if (localStorage.getItem('fix-alert')) {
                document.getElementById('fix-alert').style.display = 'none';
            }
            document.getElementById('logout').addEventListener('click', function() {
                localStorage.removeItem('fix-alert');
            });

            // Search
            

        </script>
    </div>
</body>
</html>
