<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="flex items-center gap-3 text-2xl font-black leading-tight text-slate-800">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 text-pink-500 shadow-sm">📦</span>
                    <span>Daftar Orderan Masuk</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola status pesanan, verifikasi pembayaran, dan cetak struk.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-7 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700">
                    ⚠️ {{ session('error') ?? $errors->first() }}
                </div>
            @endif

            <!-- Grid Card Rekap Laporan Harian -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
                <div class="rounded-[1.5rem] border border-slate-200/70 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.05)]">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Transaksi Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">
                        {{ $rekapHarian['total_transaksi'] ?? 0 }} <span
                            class="text-xs font-semibold text-slate-400">Order</span>
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-pink-100/70 bg-white p-5 shadow-[0_10px_24px_rgba(190,24,93,0.06)]">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Omset Harian</p>
                    <h3 class="text-2xl font-black text-pink-600 mt-1">
                        Rp {{ number_format($rekapHarian['total_pendapatan'] ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-emerald-100/70 bg-white p-5 shadow-[0_10px_24px_rgba(16,185,129,0.06)]">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pembayaran Tunai</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">
                        Rp {{ number_format($rekapHarian['total_tunai'] ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-blue-100/70 bg-white p-5 shadow-[0_10px_24px_rgba(59,130,246,0.06)]">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pembayaran Transfer & QRIS</p>
                    <h3 class="text-2xl font-black text-blue-600 mt-1">
                        Rp {{ number_format($rekapHarian['total_qris'] ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            @if($menungguVerifikasi > 0)
                <div class="flex items-center gap-3 rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-blue-700">
                    <span class="text-xl">🔔</span>
                    <div>
                        <p class="text-sm font-bold">{{ $menungguVerifikasi }} order menunggu verifikasi pembayaran</p>
                        <p class="text-xs mt-0.5">Bukti pembayaran pelanggan sudah masuk dan siap diperiksa.</p>
                    </div>
                </div>
            @endif

            <!-- Tabel Utama Pesanan -->
            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-[0_14px_34px_rgba(15,23,42,0.07)]">
                <div
                    class="flex flex-col items-start justify-between gap-4 border-b border-slate-100 p-6 xl:flex-row xl:items-center">
                    <h3 class="text-base font-extrabold tracking-tight text-slate-800">Daftar Pemesanan Masuk</h3>

                    <form action="{{ route('kasir.orders') }}" method="GET"
                        class="flex flex-col sm:flex-row items-center gap-2 w-full xl:w-auto">
                        <div
                            class="flex w-full items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 sm:w-auto">
                            <span class="text-slate-400 text-xs">📅</span>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="bg-transparent border-0 text-slate-700 text-xs font-bold focus:outline-none focus:ring-0 p-0 cursor-pointer">
                        </div>

                        <div class="relative w-full sm:w-72">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nomor order / pelanggan..."
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-xs outline-none transition focus:border-pink-500 focus:bg-white focus:ring-4 focus:ring-pink-100">
                            <button type="submit"
                                class="absolute right-3 top-2.5 text-slate-400 hover:text-pink-600">🔍</button>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="w-full rounded-2xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800 sm:w-auto">
                                Filter
                            </button>
                            @if(request('date') || request('search'))
                                <a href="{{ route('kasir.orders') }}"
                                    class="rounded-2xl bg-slate-100 px-4 py-2.5 text-center text-xs font-bold text-slate-600 transition hover:bg-slate-200">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[1120px] w-full border-collapse text-left text-xs">
                        <thead>
                            <tr
                                class="border-b border-slate-100 bg-slate-50/80 font-extrabold uppercase tracking-wider text-slate-400">
                                <th class="w-[180px] p-4">No. Order & Tanggal</th>
                                <th class="w-[170px] p-4">Pelanggan & Kontak</th>
                                <th class="w-[250px] p-4">Rincian Item</th>
                                <th class="w-[180px] p-4">Total</th>
                                <th class="w-[130px] p-4">Status</th>
                                <th class="w-[220px] p-4 text-center">Aksi Kasir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                <tr class="align-top transition-colors hover:bg-pink-50/25">
                                    <td class="p-4">
                                        <p class="font-bold text-pink-600 text-sm">#{{ $order->order_number }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">⏱️
                                            {{ $order->created_at->format('d M Y - H:i') }} WIB</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-slate-800">
                                            {{ $order->customer_name ?? $order->user->name ?? 'Pelanggan Walk-in' }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">📱 {{ $order->recipient_phone ?? '-' }}
                                        </p>
                                    </td>
                                    <td class="p-4">
                                        <ul class="space-y-1 text-slate-600">
                                            @foreach($order->items as $item)
                                                <li class="flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span>
                                                    {{ $item->product->name ?? 'Buket Bunga' }}
                                                    <span class="font-semibold text-slate-800">({{ $item->quantity }}x)</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-black text-slate-800 text-sm">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                            <span
                                                class="text-[10px] font-bold px-2 py-0.5 rounded-lg bg-slate-100 text-slate-600 uppercase">
                                                {{ $order->payment_method ?? 'Cash' }}
                                            </span>
                                            @if($order->payment_status == 'paid')
                                                <span
                                                    class="text-[10px] font-bold px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200">Lunas</span>
                                            @elseif($order->payment_status == 'Menunggu Verifikasi')
                                                <span
                                                    class="text-[10px] font-bold px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 border border-blue-200">Menunggu
                                                    Verifikasi</span>
                                            @else
                                                <span
                                                    class="text-[10px] font-bold px-2 py-0.5 rounded-lg bg-amber-50 text-amber-600 border border-amber-200">Belum
                                                    Bayar</span>
                                            @endif
                                        </div>

                                        <!-- Tombol Lihat Bukti Transfer jika pelanggan sudah upload -->
                                        @if($order->payment_proof)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                                    class="inline-flex items-center gap-1 text-[11px] font-bold text-pink-600 bg-pink-50 hover:bg-pink-100 px-2.5 py-1 rounded-lg border border-pink-200 transition shadow-sm">
                                                    <span>🔍 Lihat Bukti Transfer</span>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                                'processing' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                'cancelled' => 'bg-rose-50 text-rose-600 border-rose-200',
                                            ];
                                            $badgeClass = $statusColors[$order->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                        @endphp
                                        <span
                                            class="px-3 py-1 border rounded-full font-bold uppercase text-[10px] tracking-wider {{ $badgeClass }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center space-y-2">
                                        <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 cursor-pointer shadow-sm w-full">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                        </form>

                                        <a href="{{ route('kasir.orders.detail', $order) }}"
                                            class="block w-full rounded-xl bg-pink-50 px-3 py-2 text-[11px] font-bold text-pink-600 transition hover:bg-pink-100">
                                            🔎 Detail Pemesanan
                                        </a>

                                        <!-- Tombol Aksi Cepat Pembayaran (Sudah Dibayar / Belum Bayar) -->
                                        <div class="flex items-center gap-1.5">
                                            <form action="{{ route('kasir.orders.updatePaymentStatus', $order->id) }}"
                                                method="POST" class="w-full">
                                                @csrf
                                                @method('PATCH')
                                                @if($order->payment_status == 'paid')
                                                    <input type="hidden" name="payment_status" value="unpaid">
                                                    <button type="submit"
                                                        class="w-full bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-[10px] font-bold py-1.5 rounded-xl transition">
                                                        🔄 Ubah ke Belum Bayar
                                                    </button>
                                                @else
                                                    <input type="hidden" name="payment_status" value="paid">
                                                    <button type="submit"
                                                        class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-[10px] font-bold py-1.5 rounded-xl transition">
                                                        ✅ Tandai Sudah Dibayar
                                                    </button>
                                                @endif
                                            </form>
                                        </div>

                                        <!-- Tombol Cetak & PDF hanya muncul jika status pesanan 'completed' (selesai) -->
                                        @if($order->status == 'completed')
                                            <!-- Tombol 1: Cetak Printer Thermal 58mm -->
                                            <button type="button"
                                                data-print-receipt="receipt-{{ $order->id }}"
                                                data-order-number="{{ $order->order_number }}"
                                                data-customer-name="{{ $order->customer_name ?? $order->user->name ?? 'Walk-in' }}"
                                                data-order-date="{{ $order->created_at->format('d/m/Y H:i') }}"
                                                data-print-mode="thermal"
                                                class="w-full inline-flex items-center justify-center gap-1 bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-bold px-3 py-2 rounded-xl transition-all shadow-sm cursor-pointer">
                                                <span>🖨️ Cetak Kasir</span>
                                            </button>

                                            <!-- Tombol 2: Unduh PDF untuk WhatsApp (Ukuran Standar Proporsional A5) -->
                                            <button type="button"
                                                data-print-receipt="receipt-{{ $order->id }}"
                                                data-order-number="{{ $order->order_number }}"
                                                data-customer-name="{{ $order->customer_name ?? $order->user->name ?? 'Walk-in' }}"
                                                data-order-date="{{ $order->created_at->format('d/m/Y H:i') }}"
                                                data-print-mode="pdf"
                                                class="w-full inline-flex items-center justify-center gap-1 bg-pink-600 hover:bg-pink-700 text-white text-[11px] font-bold px-3 py-2 rounded-xl transition-all shadow-sm cursor-pointer">
                                                <span>📄 PDF / WA</span>
                                            </button>
                                        @endif

                                        <!-- Template Struk Tersembunyi -->
                                        <div id="receipt-{{ $order->id }}" class="hidden">
                                            <div
                                                style="font-family: monospace; width: 100%; color: #000; font-size: 13px; line-height: 1.4;">
                                                <div
                                                    style="text-align: center; margin-bottom: 15px; border-bottom: 2px dashed #000; padding-bottom: 10px;">
                                                    <h3 style="font-size: 18px; font-weight: bold; margin: 0;">ENDORPHINE
                                                        FLORIST</h3>
                                                    <p style="font-size: 12px; margin: 3px 0;">Jl. Raya Cianjur No. 88</p>
                                                    <p style="font-size: 12px; margin: 3px 0;">Telp: 0838-7672-7315</p>
                                                </div>

                                                <div
                                                    style="border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 10px; font-size: 12px;">
                                                    <div style="display: flex; justify-content: space-between;"><span>No.
                                                            Order:</span> <span>#{{ $order->order_number }}</span></div>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <span>Tanggal:</span>
                                                        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <span>Kasir:</span> <span>{{ Auth::user()->name }}</span></div>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <span>Pelanggan:</span>
                                                        <span>{{ $order->customer_name ?? $order->user->name ?? 'Walk-in' }}</span>
                                                    </div>
                                                </div>

                                                <div
                                                    style="border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 10px; font-size: 12px;">
                                                    @foreach($order->items as $item)
                                                        <div style="margin-bottom: 6px;">
                                                            <div style="font-weight: bold;">
                                                                {{ $item->product->name ?? 'Buket Bunga' }}</div>
                                                            <div style="display: flex; justify-content: space-between;">
                                                                <span>{{ $item->quantity }}x @ Rp
                                                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                                                <span>Rp
                                                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div
                                                    style="font-size: 14px; font-weight: bold; display: flex; justify-content: space-between; margin-bottom: 15px;">
                                                    <span>TOTAL:</span>
                                                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                                </div>

                                                <div
                                                    style="text-align: center; font-size: 11px; border-top: 1px dashed #000; padding-top: 10px;">
                                                    <p style="margin: 2px 0;">Terima Kasih Telah Berbelanja!</p>
                                                    <p style="margin: 2px 0;">🌸 Endorphine Florist 🌸</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <span class="text-3xl">📭</span>
                                            <p class="text-sm font-medium">Belum ada transaksi pesanan yang masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script JavaScript untuk Print Mode Thermal & Mode PDF A5 -->
    <script>
        document.querySelectorAll('[data-print-receipt]').forEach((button) => {
            button.addEventListener('click', () => {
                printReceipt(
                    button.dataset.printReceipt,
                    button.dataset.orderNumber,
                    button.dataset.customerName,
                    button.dataset.orderDate,
                    button.dataset.printMode
                );
            });
        });

        function printReceipt(elementId, orderNumber, customerName, orderDate, mode) {
            const receiptElement = document.getElementById(elementId);

            if (!receiptElement) {
                window.alert('Data struk tidak ditemukan. Silakan muat ulang halaman.');
                return;
            }

            const receiptContent = receiptElement.innerHTML;

            const cleanDate = orderDate.replace(/[/:]/g, '-').replace(/\s+/g, '_');
            const cleanName = customerName.replace(/[^a-zA-Z0-9]/g, '_');
            const fileName = `Struk-${cleanName}-${orderNumber}-${cleanDate}`;

            const originalTitle = document.title;

            let pageStyle = '';
            let bodyStyle = '';

            if (mode === 'thermal') {
                pageStyle = '@page { size: 58mm auto; margin: 0; }';
                bodyStyle = 'margin: 0; padding: 5px; font-family: monospace; background: #fff; width: 58mm;';
            } else {
                pageStyle = '@page { size: A5 portrait; margin: 15mm; }';
                bodyStyle = 'margin: 0; padding: 20px; font-family: monospace; background: #fff; max-width: 400px; margin-left: auto; margin-right: auto; border: 1px solid #ddd; border-radius: 8px;';
            }

            const printWindow = window.open('', '_blank', 'width=720,height=820');

            if (!printWindow) {
                window.alert('Jendela cetak diblokir browser. Izinkan pop-up untuk mencetak struk.');
                return;
            }

            let hasPrinted = false;
            const startPrint = () => {
                if (hasPrinted || printWindow.closed) {
                    return;
                }

                hasPrinted = true;
                printWindow.focus();
                printWindow.print();
                printWindow.onafterprint = () => printWindow.close();
            };

            const printDocument = printWindow.document;
            printDocument.title = fileName;

            const printStyle = printDocument.createElement('style');
            printStyle.textContent = `${pageStyle} body { ${bodyStyle} }`;
            printDocument.head.appendChild(printStyle);
            printDocument.body.innerHTML = receiptContent;

            startPrint();
            window.setTimeout(startPrint, 800);

            document.title = originalTitle;
        }
    </script>
</x-app-layout>