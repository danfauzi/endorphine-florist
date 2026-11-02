<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .title { font-size: 16pt; font-weight: bold; color: #db2777; text-align: center; }
        .subtitle { font-size: 11pt; text-align: center; color: #555555; }
        .header-table { background-color: #db2777; color: #ffffff; font-weight: bold; text-align: center; }
        .summary-title { font-weight: bold; background-color: #fdf2f8; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .number-format { mso-number-format:"\#\,\#\#0"; }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="6" class="title">ENDORPHINE FLORIST</td>
        </tr>
        <tr>
            <td colspan="6" class="subtitle">LAPORAN REKAPITULASI PENJUALAN & KEUANGAN</td>
        </tr>
        <tr>
            <td colspan="6" class="subtitle">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</td>
        </tr>
        <tr><td colspan="6"></td></tr>

        <!-- Ringkasan Keuangan -->
        <tr>
            <td class="summary-title">Total Omset:</td>
            <td class="number-format">Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
            <td class="summary-title">Pemasukan Tunai:</td>
            <td class="number-format">Rp {{ number_format($omsetTunai, 0, ',', '.') }}</td>
            <td class="summary-title">Pemasukan QRIS:</td>
            <td class="number-format">Rp {{ number_format($omsetQris, 0, ',', '.') }}</td>
        </tr>
        <tr><td colspan="6"></td></tr>

        <!-- Tabel Transaksi -->
        <thead>
            <tr>
                <th class="header-table" style="width: 50px;">No</th>
                <th class="header-table" style="width: 150px;">No. Order</th>
                <th class="header-table" style="width: 150px;">Tanggal</th>
                <th class="header-table" style="width: 200px;">Nama Pelanggan</th>
                <th class="header-table" style="width: 120px;">Metode Bayar</th>
                <th class="header-table" style="width: 150px;">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $ord)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">#{{ $ord->order_number }}</td>
                <td class="text-center">{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $ord->customer_name ?? $ord->user->name ?? 'Walk-in' }}</td>
                <td class="text-center">{{ strtoupper($ord->payment_method) }}</td>
                <td class="text-right number-format">Rp {{ number_format($ord->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>