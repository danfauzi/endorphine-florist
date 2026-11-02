<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-50 px-4 py-8 sm:px-6 sm:py-12">
            <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-pink-200/40 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -right-20 h-80 w-80 rounded-full bg-purple-200/30 blur-3xl"></div>

            <div class="relative mx-auto flex min-h-[calc(100vh-4rem)] max-w-md flex-col justify-center">
                <div class="mb-8 text-center">
                    <a href="/" class="group inline-flex flex-col items-center gap-3">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-2xl font-black text-white shadow-[0_12px_24px_rgba(236,72,153,0.25)] transition duration-300 group-hover:-translate-y-1">E</span>
                        <span class="text-lg font-black tracking-wide text-slate-800">Endorphine Florist</span>
                    </a>
                </div>

            <div class="w-full overflow-hidden rounded-[2rem] border border-white/80 bg-white/95 px-6 py-7 shadow-[0_20px_60px_rgba(15,23,42,0.10)] ring-1 ring-slate-100 sm:px-8 sm:py-8">
                {{ $slot }}
            </div>
            </div>
        </div>
    </body>
</html>
