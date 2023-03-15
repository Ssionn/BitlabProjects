<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Access Token') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's access token, it is recommended to not share the token.") }}
        </p>
    </header>


    <form method="post" action="{{ route('profile.updateToken') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="api_token" :value="__('Access Token')" />
            <x-text-input id="api_token" name="api_token" type="password" class="mt-1 block w-full" :value="old('api_token', auth()->user()->api_token)" required autofocus autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('api_token')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'Access token updated.')
                <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
