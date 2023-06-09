<x-guest-layout>
    <!-- Session Status -->

    <form method="POST" id="registerForm" action="{{ route('login') }}">
        @csrf
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-600 focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">

            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>

        </div>

    </form>

    <div id="alert-border-4" class="flex mt-4 p-4 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800" role="alert">
        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div class="ml-3 text-sm font-medium">
            <a class="underline text-sm text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a> is not implemented yet. Thank you for your patience.
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-4" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div class="h-36 min-w-screen flex items-center justify-center" id="spinner">
        <div role="status">
            <svg aria-hidden="true" class="inline w-10 h-10 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script>
        const spinner = document.getElementById('spinner');
        const form = document.getElementById('registerForm');
        spinner.classList.add('hidden');
        form.hidden = false;
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            registerStart();
            const formData = new FormData(event.target);
            fetch(event.target.action, {
                method: 'POST'
                , body: formData
            , }).finally(() => {
                ;
                setTimeout(() => {
                    registerDone();
                }, 5000);
            });
        });

        function registerStart() {
            spinner.classList.remove('hidden');
            form.hidden = true;
        }

        function registerDone() {
            spinner.classList.add('hidden');
            form.hidden = false;
            window.location.href = '/dashboard';
        }

    </script>

</x-guest-layout>

<script>
    const spinner = document.getElementById('spinner');
    const form = document.getElementById('registerForm');
    spinner.classList.add('hidden');
    form.hidden = false;
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        registerStart();
        const formData = new FormData(event.target);
        fetch(event.target.action, {
            method: 'POST'
            , body: formData
        , }).finally(() => {
            ;
            setTimeout(() => {
                registerDone();
            }, 2000);
        });
    });

    function registerStart() {
        spinner.classList.remove('hidden');
        form.hidden = true;
    }

    function registerDone() {
        spinner.classList.add('hidden');
        form.hidden = false;
        window.location.href = '/dashboard';
    }

</script>
