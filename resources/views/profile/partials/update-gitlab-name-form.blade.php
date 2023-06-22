<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Update Bitlab Username') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your account's GitLab Username.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateGitLabName') }}" class="mt-6 space-y-6" id="update-form" onsubmit="return validateForm()">

        @csrf
        @method('patch')

        <div>
            <x-input-label for="gitlab" :value="__('Bitlab username')" />
            <x-text-input id="gitlab" name="gitlab" type="text" class="mt-1 block w-full" :value="old('gitlab', auth()->user()->gitlab)" required autofocus autocomplete="gitlab" />
            <x-input-error class="mt-2" :messages="$errors->get('gitlab')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'Access token updated.')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>
        function validateInput(input) {
            const regex = /^[a-zA-Z0-9_]+$/; // this regex allows letters and numbers only
            if (!regex.test(input.value)) {
                input.setCustomValidity('Invalid input: only alphanumeric characters are allowed.');
                return false;
            } else {
                input.setCustomValidity(''); // no error
                return true;
            }
        }

        function validateForm() {
            return validateInput(document.getElementById('gitlab'));
        }

    </script>
</section>
