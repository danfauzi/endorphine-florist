<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_#fce7f3,_transparent_42%),radial-gradient(circle_at_bottom_right,_#fbcfe8,_transparent_38%),#fff7fb] flex items-center justify-center p-4 selection:bg-pink-500 selection:text-white">

    <!-- Card Container -->
    <div class="relative my-8 w-full max-w-md overflow-hidden rounded-[2rem] border border-white/80 bg-white/85 p-7 shadow-[0_24px_70px_rgba(190,24,93,0.16)] backdrop-blur-xl sm:p-9">
        
        <!-- Hiasan Background Circles -->
        <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-pink-300/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-16 -left-16 h-40 w-40 rounded-full bg-rose-300/30 blur-3xl"></div>

        <!-- Header / Logo -->
        <div class="relative z-10 mb-7 text-center">
            <a href="{{ route('home') }}" class="group mb-3 inline-flex items-center gap-2">
                <span class="text-4xl transition duration-300 group-hover:scale-110">🌸</span>
                <span class="text-2xl font-black tracking-tight text-pink-600">
                    Endorphine<span class="text-slate-800">Florist</span>
                </span>
            </a>
            <div class="mx-auto mb-3 h-1 w-10 rounded-full bg-gradient-to-r from-pink-400 to-rose-500"></div>
            <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-800">Buat Akun Baru</h2>
            <p class="mt-2 text-xs font-medium text-slate-400">Daftar untuk menikmati pemesanan buket yang lebih mudah</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 text-xs font-semibold text-rose-600 bg-rose-50 p-3.5 rounded-2xl border border-rose-100 space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5">⚠️ <span>{{ $error }}</span></p>
                @endforeach
            </div>
        @endif

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}" class="relative z-10 space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="mb-2 block text-xs font-extrabold uppercase tracking-[0.14em] text-slate-600">Nama Lengkap</label>
                <div class="relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso"
                        class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="mb-2 block text-xs font-extrabold uppercase tracking-[0.14em] text-slate-600">Alamat Email</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                        class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                </div>
            </div>

            <!-- Phone Number (Nomor HP) -->
            <div>
                <label for="phone" class="mb-2 block text-xs font-extrabold uppercase tracking-[0.14em] text-slate-600">Nomor HP / WhatsApp</label>
                <div class="relative">
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="081234567890"
                        class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="mb-2 block text-xs font-extrabold uppercase tracking-[0.14em] text-slate-600">Kata Sandi</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                        class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3.5 pr-12 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                    <button type="button" id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-pink-50 hover:text-pink-500" aria-label="Tampilkan kata sandi" aria-pressed="false">
                        <svg id="eye-closed" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                        <svg id="eye-open" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a18 18 0 0 1-3.1 3.7M6.1 6.1C3.8 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.2 2.9-.5"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="mb-2 block text-xs font-extrabold uppercase tracking-[0.14em] text-slate-600">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                        class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 px-4 py-3.5 pr-12 text-sm font-semibold text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                    <button type="button" id="toggle-password-confirmation" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-pink-50 hover:text-pink-500" aria-label="Tampilkan konfirmasi kata sandi" aria-pressed="false">
                        <svg id="eye-confirmation-closed" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                        <svg id="eye-confirmation-open" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a18 18 0 0 1-3.1 3.7M6.1 6.1C3.8 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.2 2.9-.5"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="mt-5 w-full rounded-2xl bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 py-3.5 text-sm font-extrabold text-white shadow-[0_14px_26px_rgba(236,72,153,0.28)] ring-1 ring-pink-300/60 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_18px_30px_rgba(236,72,153,0.38)]">
                Daftar Sekarang
            </button>
        </form>

        <!-- Footer Link -->
        <div class="relative z-10 mt-7 flex flex-col gap-4 border-t border-slate-100 pt-5 text-center">
            <p class="text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-pink-600 hover:text-pink-700 transition">
                    Masuk di sini
                </a>
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center self-center rounded-full border border-slate-200 bg-white/80 px-4 py-2.5 text-[11px] font-bold text-slate-500 shadow-sm transition hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600">
                Kembali ke Katalog Utama
            </a>
        </div>

    </div>

    <script>
        const setupPasswordToggle = (inputId, buttonId, closedIconId, openIconId, label) => {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const closedIcon = document.getElementById(closedIconId);
            const openIcon = document.getElementById(openIconId);

            button.addEventListener('click', () => {
                const isVisible = input.type === 'text';

                input.type = isVisible ? 'password' : 'text';
                button.setAttribute('aria-pressed', String(!isVisible));
                button.setAttribute('aria-label', `${isVisible ? 'Tampilkan' : 'Sembunyikan'} ${label}`);
                closedIcon.classList.toggle('hidden', !isVisible);
                openIcon.classList.toggle('hidden', isVisible);
            });
        };

        setupPasswordToggle('password', 'toggle-password', 'eye-closed', 'eye-open', 'kata sandi');
        setupPasswordToggle('password_confirmation', 'toggle-password-confirmation', 'eye-confirmation-closed', 'eye-confirmation-open', 'konfirmasi kata sandi');
    </script>

</body>
</html>