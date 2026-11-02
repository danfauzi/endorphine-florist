<section class="space-y-5">
    <header>
        <h2 class="text-base font-extrabold text-rose-600">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-xs leading-relaxed text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-2xl px-5 py-3 text-xs font-extrabold">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5 p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-extrabold text-slate-800">{{ __('Are you sure you want to delete your account?') }}</h2>

            <p class="text-sm leading-relaxed text-slate-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/70"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-2xl px-4 py-2.5 text-xs font-bold">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="rounded-2xl px-4 py-2.5 text-xs font-bold">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
