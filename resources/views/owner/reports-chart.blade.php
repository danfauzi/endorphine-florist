<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                <span>📊</span> Grafik Omset & Keuangan Toko
            </h2>
            <a href="{{ route('owner.reports', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-2xl transition">
                ← Kembali ke Laporan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <form method="GET" action="{{ route('owner.reports.chart') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    </div>
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    </div>
                    <button type="submit"
                        class="bg-gradient-to-r from-pink-600 to-rose-500 hover:from-pink-700 hover:to-rose-600 text-white text-xs font-bold px-5 py-2.5 rounded-2xl transition shadow-lg shadow-pink-200">
                        🔍 Tampilkan Grafik
                    </button>
                </form>
            </div>

            @php
                $chartValues = $chartTotals->toArray();
                $maxChartValue = !empty($chartValues) ? max($chartValues) : 0;
                $chartHeight = 220;
                $chartWidth = 820;
                $paddingX = 24;
                $paddingY = 24;
                $chartPoints = [];

                if (!empty($chartValues)) {
                    $count = count($chartValues);
                    foreach ($chartValues as $index => $value) {
                        $x = $paddingX + ($count === 1 ? 0 : ($index * ($chartWidth - ($paddingX * 2)) / ($count - 1)));
                        $y = $chartHeight - $paddingY - ($maxChartValue > 0 ? (($value / $maxChartValue) * ($chartHeight - ($paddingY * 2))) : 0);
                        $chartPoints[] = ['x' => $x, 'y' => $y, 'value' => $value];
                    }
                }

                $linePoints = collect($chartPoints)->map(function ($point) {
                    return $point['x'] . ',' . $point['y'];
                })->implode(' ');

                $areaPoints = '';
                if (!empty($chartPoints)) {
                    $first = $chartPoints[0];
                    $last = $chartPoints[count($chartPoints) - 1];
                    $areaPoints = $first['x'] . ',' . ($chartHeight - $paddingY) . ' ' . $linePoints . ' ' . $last['x'] . ',' . ($chartHeight - $paddingY);
                }
            @endphp

            <div class="relative overflow-hidden bg-gradient-to-br from-[#1d2d3d] via-[#1b2435] to-[#111b2a] rounded-[30px] border border-slate-700 shadow-[0_20px_60px_rgba(15,23,42,0.6)] p-6 ring-1 ring-white/5">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(244,114,182,0.18),_transparent_38%)]"></div>
                <div class="relative flex items-center justify-between mb-5">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.3em] text-slate-400">Growth</p>
                        <h3 class="text-2xl font-black text-white drop-shadow-[0_2px_8px_rgba(255,255,255,0.1)]">Grafik Omset Harian</h3>
                    </div>
                    <div class="rounded-full bg-gradient-to-r from-pink-500/30 to-fuchsia-500/20 border border-pink-400/40 px-3 py-1.5 text-[10px] font-bold text-pink-100 shadow-[0_0_18px_rgba(244,114,182,0.28)]">
                        Rp {{ number_format($totalOmset, 0, ',', '.') }} total
                    </div>
                </div>

                <div class="relative rounded-[24px] bg-[#1d2d3d]/80 p-4 border border-white/10 shadow-inner shadow-slate-950/30">
                    @if(!empty($chartPoints))
                        <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="w-full h-80">
                            <defs>
                                <linearGradient id="omsetAreaLarge" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#f9a8d4" stop-opacity="0.85" />
                                    <stop offset="58%" stop-color="#f472b6" stop-opacity="0.38" />
                                    <stop offset="100%" stop-color="#f472b6" stop-opacity="0.06" />
                                </linearGradient>
                                <filter id="chartGlow">
                                    <feGaussianBlur stdDeviation="3.5" result="blur"/>
                                    <feMerge>
                                        <feMergeNode in="blur"/>
                                        <feMergeNode in="SourceGraphic"/>
                                    </feMerge>
                                </filter>
                            </defs>
                            <g>
                                @for ($i = 0; $i <= 4; $i++)
                                    <line x1="24" y1="{{ $i * 45 + 24 }}" x2="796" y2="{{ $i * 45 + 24 }}" stroke="rgba(255,255,255,0.12)" stroke-dasharray="4 6" />
                                @endfor
                                <polygon points="{{ $areaPoints }}" fill="url(#omsetAreaLarge)" />
                                <polyline points="{{ $linePoints }}" fill="none" stroke="#f9a8d4" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" filter="url(#chartGlow)" />
                                @foreach($chartPoints as $point)
                                    <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="5.5" fill="#fff4fa" stroke="#f472b6" stroke-width="3" filter="url(#chartGlow)" />
                                    <g>
                                        <rect x="{{ $point['x'] - 26 }}" y="{{ $point['y'] - 42 }}" width="52" height="20" rx="10" fill="rgba(15,23,42,0.95)" stroke="rgba(244,114,182,0.6)" />
                                        <text x="{{ $point['x'] }}" y="{{ $point['y'] - 28 }}" text-anchor="middle" fill="#fdf2f8" font-size="10" font-weight="700">Rp {{ number_format($point['value'], 0, ',', '.') }}</text>
                                    </g>
                                @endforeach
                            </g>
                        </svg>
                        <div class="mt-4 flex justify-between text-[11px] font-semibold text-slate-300">
                            @foreach($chartLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center h-80 text-slate-300">
                            Belum ada data omset pada rentang tanggal ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-white to-pink-50 p-6 rounded-3xl border border-pink-100 shadow-[0_18px_30px_rgba(244,114,182,0.08)]">
                    <div class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">Total Omset</div>
                    <div class="mt-3 text-2xl font-black text-slate-800">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
                </div>
                <div class="bg-gradient-to-br from-white to-sky-50 p-6 rounded-3xl border border-sky-100 shadow-[0_18px_30px_rgba(56,189,248,0.08)]">
                    <div class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">Penjualan Web</div>
                    <div class="mt-3 text-2xl font-black text-slate-800">Rp {{ number_format($omsetWeb, 0, ',', '.') }}</div>
                </div>
                <div class="bg-gradient-to-br from-white to-emerald-50 p-6 rounded-3xl border border-emerald-100 shadow-[0_18px_30px_rgba(16,185,129,0.08)]">
                    <div class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">Penjualan Toko</div>
                    <div class="mt-3 text-2xl font-black text-slate-800">Rp {{ number_format($omsetToko, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
