<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="min-h-screen bg-rose-50/30 text-slate-800">
    <nav class="border-b border-pink-100 bg-white/80 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex h-20 max-w-5xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black text-pink-600">
                <span>🌸</span> Endorphine<span class="text-slate-800">Florist</span>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-pink-600">👈 Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="mx-auto max-w-5xl px-4 py-10">
        <div class="mb-8">
            <span class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-bold text-pink-600">PENGALAMAN PELANGGAN</span>
            <h1 class="mt-2 text-3xl font-black text-slate-800">Semua Ulasan</h1>
            <p class="mt-1 text-sm text-slate-500">Cerita pelanggan setelah berbelanja di Endorphine Florist.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @forelse($reviews as $review)
                <article class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="font-bold text-slate-800">{{ $review->user->name ?? 'Pelanggan' }}</h2>
                        <span class="text-lg text-amber-400">{{ str_repeat('★', $review->rating) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $review->review }}</p>
                    <p class="mt-3 text-[11px] text-slate-400">{{ optional($review->reviewed_at)->format('d M Y') }}</p>
                </article>
            @empty
                <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-8 text-center text-sm font-bold text-emerald-700 sm:col-span-2">Belum ada ulasan pelanggan.</div>
            @endforelse
        </div>
    </main>
</body>

</html>