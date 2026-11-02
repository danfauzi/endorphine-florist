<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Endorphine Florist</title>
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

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-50 border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight text-pink-600 transition hover:opacity-80">
                <span>🌸</span> Endorphine<span class="text-slate-800">Florist</span>
            </a>
            <a href="{{ route('cart.index') }}"
                class="group inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg>
                <span>Kembali ke Keranjang</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mx-auto w-full max-w-5xl px-4 py-10">
        <div class="mb-8">
            <span
                class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-extrabold text-pink-600">Checkout
                Step 2</span>
            <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-800 sm:text-3xl">Detail Pengiriman & Pembayaran</h1>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
                <p class="font-bold">Pesanan belum dapat dibuat:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-7 lg:grid-cols-3">

                <!-- Form Data Pengiriman -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="space-y-4 rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.07)]">
                        <h2 class="font-extrabold text-slate-800 text-base border-b border-slate-100 pb-3">Informasi
                            Penerima & Alamat</h2>

                        <!-- Nomor HP Penerima -->
                        <div>
                            <label for="recipient_phone" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor HP
                                / WhatsApp Penerima</label>
                            <input type="text" id="recipient_phone" name="recipient_phone"
                                value="{{ auth()->user()->phone ?? old('recipient_phone') }}" required
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 p-3.5 text-xs outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="shipping_address" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat
                                Pengiriman Lengkap</label>
                            <textarea id="shipping_address" name="shipping_address" rows="3" required
                                placeholder="Jl. Anggrek No. 45, RT 02/RW 05, Kecamatan, Kota..."
                                class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 p-3.5 text-xs outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100"></textarea>
                        </div>

                        <!-- Kartu Ucapan Custom -->
                        <div>
                            <label for="greeting_card" class="block text-xs font-bold text-slate-700 mb-1.5">Pesan Kartu
                                Ucapan (Opsional)</label>
                            <textarea id="greeting_card" name="greeting_card" rows="2"
                                placeholder="Tuliskan ucapan selamat / pesan manis untuk penerima buket..."
                                class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 p-3.5 text-xs outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Item & Tombol Buat Pesanan -->
                <div class="h-fit space-y-4 rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.08)] lg:sticky lg:top-28">

                    <!-- Rincian Belanja Sidebar -->
                    <div class="space-y-5">
                        <h2 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-3.5">Rincian
                            Belanja</h2>

                        <!-- Daftar Item & Diskon -->
                        <div class="space-y-3 text-sm text-slate-600 border-b border-slate-100 pb-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-start gap-2">
                                    <span class="text-slate-700 leading-snug">
                                        <strong class="text-slate-900 font-extrabold">{{ $item->quantity }}x</strong>
                                        {{ $item->product->name }}
                                    </span>
                                    <span class="font-bold text-slate-800 whitespace-nowrap">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            @if(isset($discount) && $discount > 0)
                                <div
                                    class="flex justify-between items-center text-emerald-600 font-bold pt-2 border-t border-slate-100 text-sm">
                                    <span>Diskon Voucher</span>
                                    <span>-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Total Pembayaran -->
                        <div class="flex justify-between items-center py-1">
                            <span class="font-bold text-slate-800 text-sm">Total Pembayaran</span>
                            <span class="font-black text-pink-600 text-xl">Rp
                                {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <!-- Pilih Metode Pembayaran -->
                        <div class="pt-3 border-t border-slate-100">
                            <label
                                class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-3">PILIH
                                METODE PEMBAYARAN</label>

                            <div class="space-y-2.5">
                                <!-- OPSI 1: TRANSFER BANK (Dinamis dari Database BankAccount Owner) -->
                                <div
                                    class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/50 transition-all duration-300">
                                    <div
                                        class="p-3.5 flex items-center justify-between cursor-pointer hover:bg-pink-50/30 transition select-none">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="payment_type" value="bank" id="radio-bank"
                                                class="accent-pink-600" onclick="togglePaymentRadio(this, 'bank')">
                                            <div>
                                                <span class="font-bold text-xs text-slate-800 block">Transfer
                                                    Bank</span>
                                                <span class="text-[10px] text-slate-400">(Disesuaikan Rekening
                                                    Toko)</span>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-400 transition-transform duration-300"
                                            id="arrow-bank">▼</span>
                                    </div>

                                    <!-- Sub Options Bank (Otomatis Sembunyi/Muncul & Sinkron Data Owner) -->
                                    <div id="bank-options"
                                        class="hidden px-3.5 pb-3.5 pt-2 space-y-2 border-t border-slate-100 bg-white">
                                        <p class="text-[10px] font-bold text-slate-400 mb-1">Pilih Bank Tujuan:</p>

                                        @php
                                            $activeBanks = \App\Models\BankAccount::where('is_active', true)
                                                ->where(function ($query) {
                                                    $query->whereNull('qris_image')
                                                        ->whereRaw('LOWER(bank_name) != ?', ['qris']);
                                                })
                                                ->get();
                                        @endphp

                                        @forelse($activeBanks as $bank)
                                            <label
                                                class="border border-slate-200 rounded-xl p-2.5 flex items-center justify-between cursor-pointer hover:border-pink-500 transition has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/30">
                                                <div class="flex items-center gap-2.5">
                                                    <input type="radio" name="payment_method" value="{{ $bank->bank_name }}"
                                                        class="accent-pink-600 bank-sub-option">
                                                    <div>
                                                        <span class="font-bold text-xs text-slate-700 block">Bank
                                                            {{ $bank->bank_name }}</span>
                                                        <span
                                                            class="text-[10px] text-slate-500 font-mono">{{ $bank->account_number }}
                                                            (a.n {{ $bank->account_holder }})</span>
                                                    </div>
                                                </div>
                                            </label>
                                        @empty
                                            <div
                                                class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-center text-xs text-slate-400">
                                                ⚠️ Belum ada rekening bank yang tersedia dari toko.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- OPSI 2: QRIS -->
                                @php
                                    $qrisAccount = \App\Models\BankAccount::where('is_active', true)
                                        ->whereNotNull('qris_image')
                                        ->first();
                                @endphp
                                <label
                                    class="border border-slate-200 rounded-2xl p-3.5 flex items-center justify-between cursor-pointer hover:border-pink-500 transition bg-slate-50/50 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/30">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="QRIS" id="radio-qris" class="accent-pink-600"
                                            onclick="togglePaymentRadio(this, 'qris')">
                                        <span class="font-bold text-xs text-slate-800">QRIS (Scan & Pay)</span>
                                    </div>
                                    <span class="text-sm">📱</span>
                                </label>
                                @if($qrisAccount?->qris_image)
                                    <div class="hidden rounded-2xl border border-pink-200 bg-pink-50 p-4 text-center" id="qris-payment-panel">
                                        <p class="text-xs font-extrabold text-pink-700 mb-3">Scan QRIS untuk membayar</p>
                                        <img src="{{ asset('storage/' . $qrisAccount->qris_image) }}" alt="QRIS pembayaran Endorphine Florist" class="mx-auto w-48 h-48 object-contain rounded-xl bg-white p-2 border border-pink-100">
                                        <p class="text-[11px] text-slate-500 mt-2">a.n {{ $qrisAccount->account_holder }}</p>
                                    </div>
                                @endif

                                <p class="rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-3 text-[11px] font-bold leading-relaxed text-amber-700">
                                    *Pembayaran Cash/Tunai hanya untuk pembelian offline atau di toko.
                                </p>
                            </div>
                        </div>

                        <!-- Script Logika Buka/Tutup Accordion & Pembersihan Nilai Payment Method -->
                        <script>
                            function togglePaymentRadio(radio, selectedMethod) {
                                const wasChecked = radio.dataset.wasChecked === 'true';

                                if (wasChecked) {
                                    radio.checked = false;
                                    radio.dataset.wasChecked = 'false';
                                    handlePaymentChange('none');
                                    return;
                                }

                                radio.dataset.wasChecked = 'true';
                                handlePaymentChange(selectedMethod);
                            }

                            function handlePaymentChange(selectedMethod) {
                                const bankRadio = document.getElementById('radio-bank');
                                const qrisRadio = document.getElementById('radio-qris');
                                const isBankSelected = selectedMethod === 'bank' || (selectedMethod === undefined && bankRadio.checked);
                                const bankContainer = document.getElementById('bank-options');
                                const arrowBank = document.getElementById('arrow-bank');
                                const bankSubOptions = document.querySelectorAll('.bank-sub-option');

                                if (isBankSelected) {
                                    qrisRadio.checked = false;
                                    qrisRadio.dataset.wasChecked = 'false';
                                    // Tampilkan dropdown bank & putar panah
                                    bankContainer.classList.remove('hidden');
                                    arrowBank.style.transform = 'rotate(180deg)';

                                    // Auto select bank pertama jika ada
                                    let anySubChecked = Array.from(bankSubOptions).some(radio => radio.checked);
                                    if (!anySubChecked && bankSubOptions.length > 0) {
                                        bankSubOptions[0].checked = true;
                                    }
                                } else {
                                    bankRadio.checked = false;
                                    if (selectedMethod === 'none') {
                                        qrisRadio.checked = false;
                                        qrisRadio.dataset.wasChecked = 'false';
                                    }
                                    // Sembunyi dropdown bank & reset panah
                                    bankContainer.classList.add('hidden');
                                    arrowBank.style.transform = 'rotate(0deg)';

                                    // Uncheck semua pilihan bank internal agar tidak mengirim nilai bank saat QRIS/Cash dipilih
                                    bankSubOptions.forEach(radio => radio.checked = false);
                                }

                                const qrisPanel = document.getElementById('qris-payment-panel');
                                if (qrisPanel) {
                                    qrisPanel.classList.toggle('hidden', !qrisRadio?.checked);
                                }
                            }
                        </script>

                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="mt-2 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 py-4 text-sm font-extrabold text-white shadow-[0_14px_28px_rgba(236,72,153,0.28)] ring-1 ring-pink-300/60 transition hover:-translate-y-0.5 hover:shadow-[0_18px_32px_rgba(236,72,153,0.38)]">
                            <span>Buat Pesanan Sekarang</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-pink-100 py-6 text-center text-xs text-slate-400 mt-12">
        <p>&copy; {{ date('Y') }} Endorphine Florist. All rights reserved.</p>
    </footer>

</body>

</html>