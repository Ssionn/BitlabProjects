<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BitlabProjects is a web application that provides an easy-to-use interface for managing and tracking your projects on Bitlab. The dashboard offers a comprehensive view of your repositories, including recent activity, commits, issues, and merge requests. It also features a notification system to keep you informed of important updates.">
    <title>BitlabProjects | Home Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <nav class="bg-gray-900 border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center">
                {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="BitlabProjects Logo" /> --}}
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">BitlabProjects</span>
            </a>
            <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 ml-3 text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 text-gray-400 hover:bg-gray-700" aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0 bg-gray-800 md:bg-gray-900 border-gray-700">
                    <li>
                        <a href="/" class="block py-2 pl-3 pr-4 rounded md:border-0 md:p-0 text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Home</a>
                    </li>
                    <li>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 pl-3 pr-4 rounded  md:border-0 md:p-0 md:w-auto text-white md:hover:text-blue-500 focus:text-white border-gray-700 hover:bg-gray-700 md:hover:bg-transparent">Dashboard <svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg></button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNavbar" class="z-10 hidden font-normal divide-y rounded-lg shadow w-44 bg-gray-700 divide-gray-600">
                            <ul class="py-2 text-sm text-gray-400" aria-labelledby="dropdownLargeButton">
                                @if(Route::has('login'))
                                @auth
                                <li class="px-4 py-2 text-xl mb-2">
                                    Welcome,
                                    <span class=" font-bold text-white">{{ ucfirst(Auth::user()->name) }}</span>
                                </li>
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="block px-4 py-2 hover:bg-gray-600 hover:text-white">Dashboard</a>
                                </li>
                                @else
                                <li>
                                    <a href="{{ route('login') }}" class="text-lg block px-4 py-2 hover:bg-gray-600 hover:text-white">Log in</a>

                                </li>
                                <li>
                                    @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-lg block px-4 py-2 hover:bg-gray-600 hover:text-white">Register</a>

                                    @endif
                                </li>
                                @endauth
                                @endif
                            </ul>
                            @if(Route::has('login'))
                            @auth
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>

                            </div>
                            @endauth
                            @endif
                        </div>
                    </li>
                    <li>
                        <a href="/contact" class="block py-2 pl-3 pr-4 rounded md:border-0 md:p-0 text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="bg-center bg-no-repeat bg-gradient-to-r from-violet-500 to-yellow-500 bg-gray-700">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Welcome to BitlabProjects: Centralized Project Management for Developers</h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Unleash the full potential of your Bitlab repositories with BitlabProjects! Our platform gives you an all-in-one view of your projects' recent activity, commits, issues, and merge requests, all in a user-friendly interface.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <a href="{{ route('login') }}" class="inline-flex justify-center items-center py-3 mb-2 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Get started
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <p class="text-white text-xs">if you're already logged in, it will redirect to the dashboard.</p>
        </div>
    </section>

    <div id="contact-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Contact Information
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="contact-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Email: <a href="mailto:163021@student.horizoncollege.nl">163021@student.horizoncollege.nl</a>
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Twitter: <a href="https://twitter.com/Ssionn2_">@Ssionn</a>
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Github: <a href="https://github.com/Ssionn">Ssionn</a>
                    </p>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <hr class="border-gray-200 sm:mx-auto dark:border-gray-700" />
                        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://bitlabprojects.nl/" class="hover:underline">BitlabProjects</a>. All Rights Reserved.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="about-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        About Us
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="about-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Welcome to BitlabProjects - your one-stop platform designed to optimize your Bitlab project management and tracking experience. We're a team of dedicated developers and project management enthusiasts committed to revolutionizing the way developers interact with their Bitlab repositories.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Our platform excels at providing a comprehensive overview of your projects, delivering critical insights into recent activity, commits, issues, and merge requests. Our user-friendly interface makes it easy to manage multiple projects, enabling seamless tracking and organization that saves you valuable time.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        At BitlabProjects, we're not just providing a tool, but crafting an efficient and organized ecosystem for your coding projects. We understand the complexities of handling multiple projects and are committed to continuous innovation to meet your evolving needs. Join us and experience project management done right.
                    </p>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Written by: Casper Kizewski
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="license-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Licensing
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="license-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        BitlabProjects is proud to be an open-source project licensed under the Apache License 2.0. We believe in the ethos of collaborative development and are pleased to offer our software under a license that encourages innovation and shared progress.
                    </p>
                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Apache License 2.0
                    </h2>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        The Apache License is a permissive free software license written by the Apache Software Foundation (ASF). It allows users to use the software for any purpose, to distribute it, to modify it, and to distribute modified versions of the software under the terms of the license, without concern for royalties.

                        This means you can freely use, modify, and distribute your own projects that include any part of the BitlabProjects, provided you adhere to the terms and conditions set by the Apache License 2.0.
                    </p>
                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        License Terms and conditions
                    </h2>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">The full details of our <a href="http://www.apache.org/licenses/LICENSE-2.0" class="underline">Apache License 2.0</a>.</p>


                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">To summarize the most crucial points:</p>

                    <ul class="text-base leading-relaxed text-gray-500 dark:text-gray-400">

                        <li>You are free to use, modify, and distribute this software.</li>
                        <li>You can include this software in your own projects, either in its original form or in a modified form.</li>
                        <li>You must include a copy of the license in any redistribution of the software.</li>
                        <li>You must include a NOTICE file if one exists in the original software.</li>
                    </ul>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">Please note that the software is provided "as is", without warranties or conditions of any kind. Please refer to the full license text for complete information.</p>

                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">BitlabProjects' source code is freely available, and we welcome contributions from our community. Let's build a better way to manage projects together!</p>


                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <hr class="border-gray-200 sm:mx-auto dark:border-gray-700" />
                        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://bitlabprojects.nl/" class="hover:underline">BitlabProjects</a>. All Rights Reserved.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="privacy-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Privacy Policy
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="privacy-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Last updated: 2023-06-09 (in format YYYY-MM-DD)
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">At BitlabProjects, your privacy is important to us. This Privacy Policy applies to all of the products, services, and websites offered by BitlabProjects.</p>
                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Information We Collect
                    </h2>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        We may collect information in the following ways:
                    </p>
                    <ul class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <li>Information you give us. For example, our services require you to sign up for an account. When you do, we’ll ask for personal information, like your name, email address, and so on.</li>
                        <li>Information we get from your use of our services. We collect information about the services that you use and how you use them, like when you visit a website that uses our advertising services or you view and interact with our ads and content.</li>
                    </ul>

                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        How We Use Information We Collect
                    </h2>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        We use the information we collect from all of our services to provide, maintain, protect, and improve them, to develop new ones, and to protect BitlabProjects and our users.
                    </p>

                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Information We Share
                    </h2>

                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        We do not share personal information with companies, organizations, and individuals outside of BitlabProjects unless one of the following circumstances applies:
                    </p>

                    <ul class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <li>With your consent.</li>
                        <li>For legal reasons.</li>
                    </ul>

                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Information Security
                    </h2>

                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        We work hard to protect BitlabProjects and our users from unauthorized access to or unauthorized alteration, disclosure, or destruction of information we hold.
                    </p>

                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Changes to Our Privacy Policy
                    </h2>

                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Our Privacy Policy may change from time to time. We will post any privacy policy changes on this page and, if the changes are significant, we will provide a more prominent notice.
                    </p>

                    <h2 class="text-base leading-relaxed text-gray-500 font-bold dark:text-gray-400">
                        Questions
                    </h2>


                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        If you have any questions about this Privacy Policy, please checkout our contact page.
                    </p>


                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <hr class="border-gray-200 sm:mx-auto dark:border-gray-700" />
                        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://bitlabprojects.nl/" class="hover:underline">BitlabProjects</a>. All Rights Reserved.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center space-x-44 sm:flex-row mt-36 mb-20">
        <div class="relative border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px]">
            <div class="h-[32px] w-[3px] bg-gray-800 dark:bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
            <div class="h-[46px] w-[3px] bg-gray-800 dark:bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
            <div class="h-[46px] w-[3px] bg-gray-800 dark:bg-gray-800 absolute -left-[17px] top-[178px] rounded-l-lg"></div>
            <div class="h-[64px] w-[3px] bg-gray-800 dark:bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
            <div class="rounded-[2rem] overflow-hidden w-[272px] h-[572px] bg-white dark:bg-gray-800">
                <img src="{{ asset('img/mobilepag2.png') }}" class="dark:hidden w-[279px] h-[572px]" alt="Mobile Page">
            </div>
        </div>

        <div class="mt-20">
            <h1 class="text-4xl font-extrabold tracking-tight leading-none sm:text-2xl md:text-3xl">Look at Recent Activity</h1>
            <p class="mt-5 break-all text-lg font-normal text-gray-600 lg:text-xl ">Unleash the full potential of your Bitlab <br> repositories with BitlabProjects! <br><br> Our platform gives you an all-in-one view of your <br> projects' recent activity, commits, issues, and merge requests, <br> all in a user-friendly interface.</p>
        </div>
    </div>
    <div class="flex justify-center mt-36 mb-20">
        <ol class="relative border-l border-gray-200 dark:border-gray-700">
            <li class="mb-10 ml-4">
                <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Juni 2023</time>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Launching of the website 🎉🎉🎉</h3>
                <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">We're thrilled to announce the launch of BitlabProjects, a cutting-edge platform designed to manage and track your projects. Start exploring today!</p>

            </li>
            {{-- <li class="mb-10 ml-4">
            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">March 2022</time>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Marketing UI design in Figma</h3>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">All of the pages and components are first designed in Figma and we keep a parity between the two versions even as we update the project.</p>
        </li> --}}
            {{-- <li class="ml-4">
            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">April 2022</time>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">E-Commerce UI code in Tailwind CSS</h3>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Get started with dozens of web components and interactive elements built on top of Tailwind CSS.</p>
        </li> --}}
        </ol>
    </div>


    <footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="https://bitlabprojects.com/" class="flex items-center mb-4 sm:mb-0">
                    {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" /> --}}
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">BitlabProjects</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a type="button" class="mr-4 hover:underline md:mr-6" data-modal-target="about-modal" data-modal-toggle="about-modal">About Us</a>
                    </li>
                    <li>
                        <a type="button" class="mr-4 hover:underline md:mr-6" data-modal-target="privacy-modal" data-modal-toggle="privacy-modal">Privacy Policy</a>
                    </li>
                    <li>
                        <a type="button" class="mr-4 hover:underline md:mr-6" data-modal-target="license-modal" data-modal-toggle="license-modal">Licensing</a>

                    </li>
                    <li>
                        <a type="button" class="hover:underline" data-modal-target="contact-modal" data-modal-toggle="contact-modal">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://bitlabprojects.nl/" class="hover:underline">BitlabProjects</a>. All Rights Reserved.</span>
        </div>
    </footer>




</body>
</html>
