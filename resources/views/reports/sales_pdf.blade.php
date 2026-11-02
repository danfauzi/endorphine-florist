<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-b: 2px solid #db2777; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #db2777; font-size: 18px; }
        .header p { margin: 2px 0; font-size: 10px; color: #666; }
        .summary { margin-bottom: 15px; width: 100%; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { padding: 6px; background: #fdf2f8; border: 1px solid #fbcfe8; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        .table th { background-color: #f8fafc; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>ENDORPHINE FLORIST</h2>
        <p>Laporan Rekapitulasi Penjualan & Keuangan</p>
        <p><strong>Periode:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Omset:</strong> Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
                <td><strong>Pemasukan Tunai:</strong> Rp {{ number_format($omsetTunai, 0, ',', '.') }}</td>
                <td><strong>Pemasukan QRIS:</strong> Rp {{ number_format($omsetQris, 0, ',', '.') }}</td>
                <td><strong>Total Order Selesai:</strong> {{ $orders->count() }} Transaksi</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Metode</th>
                <th class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $ord)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>#{{ $ord->order_number }}</td>
                <td>{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $ord->customer_name ?? $ord->user->name ?? 'Walk-in' }}</td>
                <td>{{ strtoupper($ord->payment_method) }}</td>
                <td class="text-right">Rp {{ number_format($ord->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>