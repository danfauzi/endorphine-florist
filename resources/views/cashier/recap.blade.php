<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                    <span>📋</span> Rekap Kas Harian & Penutupan Shift
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola modal awal, hitung fisik laci, dan rekapitulasi shift kasir.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Grid Card Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Modal Kas Awal</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">
                        Rp {{ number_format($modalAwal, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Kas uang kecil di laci</p>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tunai (Cash)</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">
                        Rp {{ number_format($totalTunai, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $jumlahTransaksiTunai }} Transaksi Tunai</p>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transfer & QRIS</p>
                    <h3 class="text-2xl font-black text-pink-600 mt-1">
                        Rp {{ number_format($totalQris, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $jumlahTransaksiQris }} Transaksi Digital</p>
                </div>

                <div class="bg-slate-900 p-5 rounded-3xl text-white shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kas Fisik Laci</p>
                    <h3 class="text-2xl font-black text-pink-400 mt-1">
                        Rp {{ number_format($totalKasFisik, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Modal Awal + Total Tunai</p>
                </div>

                <div class="bg-pink-600 p-5 rounded-3xl text-white shadow-sm">
                    <p class="text-xs font-bold text-pink-100 uppercase tracking-wider">Total Keseluruhan Pendapatan</p>
                    <h3 class="text-2xl font-black text-white mt-1">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-pink-100 mt-0.5">Modal + Tunai + Transfer/QRIS</p>
                </div>
            </div>

            <!-- Bagian Form Input & Riwayat Rekap -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Form Penutupan Kasir -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <h3 class="font-bold text-base text-slate-800">Input Penutupan Kasir</h3>
                    
                    <form action="{{ route('kasir.recap.storeModal') }}" method="POST" class="space-y-2">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Modal Kas Awal (Rp)</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="modal_awal" value="{{ $modalAwal }}" required
                                    class="w-full text-xs border border-slate-200 rounded-2xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/25 focus:border-pink-500">
                                <button type="submit" 
                                    class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl transition shadow-sm whitespace-nowrap cursor-pointer">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="border-slate-100">

                    <form action="{{ route('kasir.recap.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="modal_awal" value="{{ $modalAwal }}">

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Nama Kasir Bertugas</label>
                            <input type="text" value="{{ Auth::user()->name }}" readonly
                                class="w-full text-xs border border-slate-200 rounded-2xl px-4 py-2.5 bg-slate-50 text-slate-500 font-semibold">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Hitung Fisik Uang di Laci (Rp)</label>
                            <input type="number" name="physical_cash" placeholder="Masukkan total uang fisik di laci..." required
                                class="w-full text-xs border border-slate-200 rounded-2xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/25 focus:border-pink-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Catatan Kasir / Selisih</label>
                            <textarea name="notes" rows="3" placeholder="Catatan opsional..."
                                class="w-full text-xs border border-slate-200 rounded-2xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/25 focus:border-pink-500"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-pink-600 hover:bg-pink-700 text-white font-extrabold text-xs rounded-2xl transition shadow-md cursor-pointer">
                            🔒 Simpan & Tutup Kasir Hari Ini
                        </button>
                    </form>
                </div>

                <!-- Kolom Kanan: Riwayat Rekap Shift Terakhir & Filter Tanggal -->
                <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-4">
                        <h3 class="font-bold text-base text-slate-800">Riwayat Rekap Shift Terakhir</h3>
                        
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <!-- Form Filter Tanggal -->
                            <form action="{{ route('kasir.recap') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-2xl">
                                    <span class="text-slate-400 text-xs">📅</span>
                                    <input type="date" name="date" value="{{ request('date') }}"
                                        class="bg-transparent border-0 text-slate-700 text-xs font-bold focus:outline-none focus:ring-0 p-0 cursor-pointer">
                                </div>
                                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-2xl transition shadow-sm">
                                    Filter
                                </button>
                                @if(request('date'))
                                    <a href="{{ route('kasir.recap') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-2xl transition">
                                        Reset
                                    </a>
                                @endif
                            </form>

                            <button type="button" onclick="printShiftRecap()"
                                class="inline-flex items-center gap-1.5 bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs px-4 py-2 rounded-2xl transition shadow-sm cursor-pointer whitespace-nowrap">
                                <span>🖨️</span> Cetak Rekap
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/70 text-slate-400 uppercase tracking-wider font-semibold border-b border-slate-100">
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Kasir</th>
                                    <th class="p-3">Tunai</th>
                                    <th class="p-3">Transfer & QRIS</th>
                                    <th class="p-3">Selisih Laci</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($riwayatRecaps as $recap)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-3 font-semibold text-slate-700">{{ \Carbon\Carbon::parse($recap->created_at)->format('d M Y') }}</td>
                                        <td class="p-3 font-semibold text-slate-800">{{ $recap->user->name ?? 'Kasir' }}</td>
                                        <td class="p-3 text-emerald-600 font-bold">Rp {{ number_format($recap->total_tunai ?? 0, 0, ',', '.') }}</td>
                                        <td class="p-3 text-pink-600 font-bold">Rp {{ number_format($recap->total_qris ?? 0, 0, ',', '.') }}</td>
                                        <td class="p-3 font-bold {{ ($recap->selisih ?? 0) < 0 ? 'text-rose-600' : 'text-slate-700' }}">
                                            Rp {{ number_format($recap->selisih ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-slate-400">
                                            Belum ada riwayat rekap shift untuk tanggal tersebut.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Template Cetak / PDF Laporan Rekap Shift Tersembunyi -->
    <div id="print-recap-section" class="hidden">
        <div style="font-family: monospace; width: 100%; color: #000; font-size: 11px; line-height: 1.3; padding: 10px;">
            <div style="text-align: center; margin-bottom: 15px; border-bottom: 2px dashed #000; padding-bottom: 10px;">
                <h2 style="font-size: 16px; font-weight: bold; margin: 0;">ENDORPHINE FLORIST</h2>
                <p style="font-size: 11px; margin: 3px 0;">LAPORAN REKAP KAS HARIAN & SHIFT</p>
                <p style="font-size: 10px; margin: 2px 0;">Tanggal: {{ request('date') ? request('date') : date('d/m/Y') }}</p>
            </div>

            <div style="margin-bottom: 15px; font-size: 11px; border-bottom: 1px dashed #000; padding-bottom: 10px;">
                <div style="margin-bottom: 3px;">Kasir: <strong>{{ Auth::user()->name }}</strong></div>
                <div style="margin-bottom: 3px;">Modal Awal: <strong>Rp {{ number_format($modalAwal, 0, ',', '.') }}</strong></div>
                <div style="margin-bottom: 3px;">Total Tunai: <strong>Rp {{ number_format($totalTunai, 0, ',', '.') }}</strong></div>
                <div style="margin-bottom: 3px;">Total Transfer & QRIS: <strong>Rp {{ number_format($totalQris, 0, ',', '.') }}</strong></div>
                <div style="margin-top: 5px; font-weight: bold; font-size: 12px;">
                    Total Kas Fisik: Rp {{ number_format($totalKasFisik, 0, ',', '.') }}
                </div>
            </div>

            <div style="font-size: 12px; font-weight: bold; margin-bottom: 6px;">Riwayat Shift:</div>
            <table style="width: 100%; border-collapse: collapse; font-size: 9.5px; table-layout: fixed;">
                <thead>
                    <tr style="border-bottom: 1px solid #000;">
                        <th style="text-align: left; padding: 3px 2px; width: 15%;">TGL</th>
                        <th style="text-align: left; padding: 3px 2px; width: 25%;">KASIR</th>
                        <th style="text-align: left; padding: 3px 2px; width: 18%;">TUNAI</th>
                        <th style="text-align: left; padding: 3px 2px; width: 14%;">Transfer & QRIS</th>
                        <th style="text-align: left; padding: 3px 2px; width: 28%;">SELISIH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatRecaps as $recap)
                        <tr style="border-bottom: 1px dotted #ccc;">
                            <td style="padding: 3px 2px; overflow: hidden; white-space: nowrap;">{{ \Carbon\Carbon::parse($recap->created_at)->format('d/m/y') }}</td>
                            <td style="padding: 3px 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $recap->user->name ?? 'Kasir' }}</td>
                            <td style="text-align: left; padding: 3px 2px; overflow: hidden; white-space: nowrap;">{{ number_format($recap->total_tunai ?? 0, 0, ',', '.') }}</td>
                            <td style="text-align: left; padding: 3px 2px; overflow: hidden; white-space: nowrap;">{{ number_format($recap->total_qris ?? 0, 0, ',', '.') }}</td>
                            <td style="text-align: left; padding: 3px 2px; overflow: hidden; white-space: nowrap;">{{ number_format($recap->selisih ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align: center; font-size: 10px; border-top: 2px dashed #000; margin-top: 20px; padding-top: 10px;">
                <p style="margin: 2px 0;">Endorphine Florist - Kasir Shift Report</p>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Print & Simpan PDF Rekap Shift -->
    <script>
        function printShiftRecap() {
            const content = document.getElementById('print-recap-section').innerHTML;
            const fileName = `Rekap-Shift-{{ Auth::user()->name }}-{{ date('Y-m-d') }}`;
            const originalTitle = document.title;

            const printWindow = window.open('', '_blank', 'width=900,height=700');

            if (!printWindow) {
                window.alert('Jendela cetak diblokir browser. Izinkan pop-up untuk mencetak rekap.');
                return;
            }

            const printDocument = printWindow.document;
            printDocument.title = fileName;

            const printStyle = printDocument.createElement('style');
            printStyle.textContent = '@page { size: A5 landscape; margin: 10mm; } body { margin: 0; padding: 0; font-family: monospace; background: #fff; width: 100%; }';
            printDocument.head.appendChild(printStyle);
            printDocument.body.innerHTML = content;

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

            printWindow.onload = startPrint;
            window.setTimeout(startPrint, 800);
            document.title = originalTitle;
        }
    </script>
</x-app-layout>