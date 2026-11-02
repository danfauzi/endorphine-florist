<section>
    <header>
        <h2 class="text-base font-extrabold text-slate-800">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-xs leading-relaxed text-slate-400">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 max-w-xl space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <div x-data="{ visible: false }" class="relative mt-2">
                <input id="update_password_current_password" name="current_password" x-bind:type="visible ? 'text' : 'password'" autocomplete="current-password"
                    class="block w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3 pr-12 text-sm font-semibold text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                <button type="button" x-on:click="visible = !visible" x-bind:aria-label="visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-pink-50 hover:text-pink-500">
                    <svg x-show="!visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                    <svg x-show="visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a18 18 0 0 1-3.1 3.7M6.1 6.1C3.8 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.2 2.9-.5"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <div x-data="{ visible: false }" class="relative mt-2">
                <input id="update_password_password" name="password" x-bind:type="visible ? 'text' : 'password'" autocomplete="new-password"
                    class="block w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3 pr-12 text-sm font-semibold text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                <button type="button" x-on:click="visible = !visible" x-bind:aria-label="visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-pink-50 hover:text-pink-500">
                    <svg x-show="!visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                    <svg x-show="visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a18 18 0 0 1-3.1 3.7M6.1 6.1C3.8 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.2 2.9-.5"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <div x-data="{ visible: false }" class="relative mt-2">
                <input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="visible ? 'text' : 'password'" autocomplete="new-password"
                    class="block w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3 pr-12 text-sm font-semibold text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                <button type="button" x-on:click="visible = !visible" x-bind:aria-label="visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-pink-50 hover:text-pink-500">
                    <svg x-show="!visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                    <svg x-show="visible" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a18 18 0 0 1-3.1 3.7M6.1 6.1C3.8 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.2 2.9-.5"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-2xl bg-pink-600 px-5 py-3 text-xs font-extrabold shadow-lg shadow-pink-200 hover:bg-pink-700">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
