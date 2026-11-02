<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen flex-col justify-between bg-[radial-gradient(circle_at_top_left,_#fff1f7,_transparent_34%),#fffafb] text-slate-800">

    <!-- Navbar Sederhana -->
    <nav class="sticky top-0 z-50 border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight text-pink-600 transition hover:opacity-80">
                <span>🌸</span> Endorphine<span class="text-slate-800">Florist</span>
            </a>
        </div>
    </nav>

    <!-- Konten Utama Sukses -->
    <main class="mx-auto w-full max-w-xl px-4 py-12 sm:py-16">
        <div class="space-y-6 rounded-[2rem] border border-pink-100/70 bg-white p-6 text-center shadow-[0_24px_60px_rgba(190,24,93,0.12)] sm:p-8">

            <div
                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 shadow-sm ring-8 ring-emerald-50/60">
                <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"></path></svg>
            </div>

            <div>
                <span
                    class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-extrabold uppercase tracking-wider text-pink-600">
                    #ORD-{{ $order->id }}
                </span>
                <h1 class="mt-3 text-2xl font-black tracking-tight text-slate-800">Pesanan Berhasil Dibuat!</h1>
                <p class="mt-2 text-xs leading-relaxed text-slate-400">
                    Terima kasih sudah memesan di Endorphine Florist. Silakan selesaikan pembayaran sesuai instruksi di
                    bawah ini.
                </p>
            </div>

            @if(session('success'))
                <div
                    class="mb-4 flex items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50 p-3 text-left text-xs font-bold text-emerald-700">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div
                    class="mb-4 rounded-2xl border border-rose-100 bg-rose-50 p-3 text-left text-xs font-bold text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Detail Pesanan -->
            <div class="space-y-2.5 rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4 text-left text-xs shadow-inner shadow-slate-100">
                <div class="flex justify-between">
                    <span class="text-slate-500">Status Pesanan</span>
                    <span
                        class="font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md uppercase">{{ $order->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Metode Pembayaran</span>
                    <span class="font-bold text-slate-800">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status Pembayaran</span>
                    <span class="font-bold text-pink-600">{{ $order->payment_status ?? 'unpaid' }}</span>
                </div>
                <div class="flex justify-between pt-2 border-t border-slate-200">
                    <span class="font-bold text-slate-700">Total Pembayaran</span>
                    <span class="font-black text-pink-600 text-base">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Instruksi Bank / QRIS -->
            <!-- Kotak Informasi Rekening Tujuan Transfer -->
            @if($order->payment_method != 'Cash' && $order->payment_method != 'QRIS')
                @php
                    $bankInfo = \App\Models\BankAccount::where('bank_name', $order->payment_method)->where('is_active', true)->first();
                @endphp

                @if($bankInfo)
                    <div class="my-4 space-y-1.5 rounded-2xl border border-pink-200 bg-pink-50/70 p-5 text-center">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-pink-600">Silakan Transfer
                            Pembayaran Ke:</span>
                        <div class="font-black text-slate-800 text-sm">Bank {{ $bankInfo->bank_name }}</div>
                        <div class="font-mono font-extrabold text-pink-600 text-lg tracking-wider">
                            {{ $bankInfo->account_number }}
                        </div>
                        <div class="text-xs font-bold text-slate-600">a.n {{ $bankInfo->account_holder }}</div>
                    </div>
                @endif
            @endif

            @if($order->payment_method === 'QRIS')
                @php
                    $qrisAccount = \App\Models\BankAccount::where('is_active', true)->whereNotNull('qris_image')->first();
                @endphp
                @if($qrisAccount?->qris_image)
                    <div class="my-4 space-y-3 rounded-2xl border border-pink-200 bg-pink-50/70 p-5 text-center shadow-sm">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-pink-600">Scan QRIS untuk Membayar</span>
                        <img src="{{ asset('storage/' . $qrisAccount->qris_image) }}" alt="QRIS pembayaran Endorphine Florist" class="mx-auto h-52 w-52 rounded-2xl border border-pink-100 bg-white p-2 shadow-sm">
                        <div class="text-xs font-bold text-slate-600">a.n {{ $qrisAccount->account_holder }}</div>
                    </div>
                @endif
            @endif

            <!-- Form Upload Bukti Bayar -->
            @if(!$order->payment_proof && $order->payment_method !== 'Cash')
                <form id="payment-proof-form" action="{{ route('orders.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4 rounded-2xl border border-dashed border-pink-200 bg-pink-50/40 p-5 text-left">
                    @csrf
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">Upload Bukti Pembayaran</label>
                        <p class="mt-1 text-[11px] leading-relaxed text-slate-400">Pilih foto atau screenshot bukti transfer yang sudah kamu lakukan.</p>
                    </div>
                    <input type="file" name="payment_proof" accept="image/*" required
                        class="w-full rounded-xl border border-pink-100 bg-white p-2 text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-pink-100 file:px-3 file:py-2 file:text-xs file:font-extrabold file:text-pink-600">
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-800 py-3 text-xs font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-slate-900 hover:shadow-lg">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M5 14v5h14v-5"></path></svg>
                        <span>Kirim Bukti Pembayaran</span>
                    </button>
                </form>
            @endif

            <script>
                document.getElementById('payment-proof-form')?.addEventListener('submit', async function (event) {
                    const input = this.querySelector('input[name="payment_proof"]');
                    const file = input?.files?.[0];

                    if (!file || !file.type.startsWith('image/') || file.size <= 1500000) {
                        return;
                    }

                    event.preventDefault();

                    const image = new Image();
                    image.onload = () => {
                        const scale = Math.min(1, 1600 / Math.max(image.width, image.height));
                        const canvas = document.createElement('canvas');
                        canvas.width = Math.round(image.width * scale);
                        canvas.height = Math.round(image.height * scale);
                        canvas.getContext('2d').drawImage(image, 0, 0, canvas.width, canvas.height);
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                this.submit();
                                return;
                            }

                            const compressed = new File([blob], 'payment-proof.jpg', { type: 'image/jpeg' });
                            const transfer = new DataTransfer();
                            transfer.items.add(compressed);
                            input.files = transfer.files;
                            this.submit();
                        }, 'image/jpeg', 0.8);
                    };
                    image.src = URL.createObjectURL(file);
                });
            </script>

            <a href="{{ route('home') }}"
                class="flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 py-3.5 text-xs font-extrabold text-white shadow-[0_14px_28px_rgba(236,72,153,0.28)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_32px_rgba(236,72,153,0.38)]">
                Kembali ke Beranda
            </a>

        </div>
    </main>

    <footer class="bg-white border-t border-pink-100 py-6 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Endorphine Florist. All rights reserved.</p>
    </footer>

</body>

</html>