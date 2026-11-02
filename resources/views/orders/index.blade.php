<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ request('status') === 'unpaid' ? 'Pesanan Belum Bayar' : (request('status') === 'review' ? 'Penilaian' : 'Riwayat Transaksi') }} - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_#fff1f7,_transparent_34%),#fffafb] text-slate-800">
    <nav class="border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-20 max-w-5xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight text-pink-600 transition hover:opacity-80">
                <span>🌸</span> Endorphine<span class="text-slate-800">Florist</span>
            </a>
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </nav>

    <main class="mx-auto max-w-5xl px-4 py-10">
        <div class="mb-8">
            <span class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-extrabold tracking-wide text-pink-600">{{ request('status') === 'unpaid' ? 'STATUS PESANAN' : (request('status') === 'review' ? 'PENILAIAN PESANAN' : 'RIWAYAT PEMBELIAN') }}</span>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-800">{{ request('status') === 'unpaid' ? 'Belum Bayar' : (request('status') === 'review' ? 'Penilaian' : 'Riwayat Transaksi') }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ request('status') === 'unpaid' ? 'Lanjutkan pembayaran untuk pesanan yang belum selesai.' : (request('status') === 'review' ? 'Berikan penilaian untuk pesanan yang sudah selesai.' : 'Lihat produk dan rincian dari semua pembelianmu.') }}</p>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-bold text-emerald-700">{{ session('success') }}</div>
        @endif

        @forelse($orders as $order)
            <article class="mb-5 rounded-[1.75rem] border border-pink-100/70 bg-white p-5 shadow-[0_12px_30px_rgba(190,24,93,0.07)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_34px_rgba(190,24,93,0.11)]">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-black text-pink-600">#{{ $order->order_number }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $order->created_at->format('d M Y - H:i') }} WIB</p>
                            </div>
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wide text-amber-600">{{ $order->payment_status }}</span>
                        </div>
                        <div class="mt-4 space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-3 rounded-2xl bg-slate-50/80 p-2.5">
                                    @if($item->product?->image)
                                        <img src="{{ str_starts_with($item->product->image, 'http') || str_starts_with($item->product->image, 'data:') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Produk' }}" class="h-14 w-14 rounded-xl object-cover ring-2 ring-white shadow-sm">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-pink-50 text-pink-500">🌸</div>
                                    @endif
                                    <p class="text-sm text-slate-700"><span class="font-extrabold text-slate-900">{{ $item->quantity }}x</span> {{ $item->product->name ?? 'Produk' }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex flex-wrap items-end justify-between gap-3 border-t border-slate-100 pt-3">
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-wide text-slate-400">Metode {{ $order->payment_method }}</p>
                                <p class="mt-1 text-lg font-black text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @if(request('status') === 'review')
                        <form action="{{ route('orders.review', $order) }}" method="POST" class="rating-form w-full space-y-3 sm:w-80">
                            @csrf
                            <div class="flex items-center justify-between gap-2 rounded-2xl bg-amber-50 px-3 py-2">
                                <span class="text-xs font-bold text-slate-700">Beri bintang</span>
                                <div class="rating-stars flex justify-end gap-1" aria-label="Pilih rating 1 sampai 5">
                                    @for($rating = 1; $rating <= 5; $rating++)
                                        <input id="rating-{{ $order->id }}-{{ $rating }}" type="radio" name="rating" value="{{ $rating }}" class="rating-input sr-only" required>
                                        <label for="rating-{{ $order->id }}-{{ $rating }}" data-rating="{{ $rating }}" class="rating-star cursor-pointer text-xl text-slate-300 transition hover:text-amber-400">★</label>
                                    @endfor
                                </div>
                            </div>
                            <textarea name="review" rows="3" required maxlength="1000" placeholder="Tulis deskripsi pengalamanmu..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-xs focus:border-pink-500 focus:bg-white focus:outline-none"></textarea>
                            <button type="submit" class="w-full rounded-2xl bg-pink-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-pink-200 hover:bg-pink-700">Kirim Penilaian</button>
                        </form>
                    @elseif($order->payment_status === 'unpaid')
                        <a href="{{ route('orders.success', $order->id) }}" class="rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-3 text-center text-xs font-extrabold text-white shadow-lg shadow-pink-200 transition hover:-translate-y-0.5 hover:shadow-xl">
                            Lanjutkan Pembayaran
                        </a>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-8 text-center text-sm font-bold text-emerald-700">
                {{ request('status') === 'review' ? 'Belum ada pesanan yang bisa diberi penilaian.' : (request('status') === 'unpaid' ? 'Tidak ada pesanan yang belum dibayar.' : 'Belum ada riwayat transaksi.') }}
            </div>
        @endforelse
    </main>

    <script>
        document.querySelectorAll('.rating-form').forEach((form) => {
            const stars = Array.from(form.querySelectorAll('.rating-star'));
            const inputs = Array.from(form.querySelectorAll('.rating-input'));

            const updateStars = (rating) => {
                stars.forEach((star) => {
                    star.classList.toggle('text-amber-400', Number(star.dataset.rating) <= rating);
                    star.classList.toggle('text-slate-300', Number(star.dataset.rating) > rating);
                });
            };

            inputs.forEach((input) => {
                input.addEventListener('change', () => updateStars(Number(input.value)));
            });
        });
    </script>
</body>

</html>