<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // Query Utama Order Completed
        $completedQuery = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // 1. Total Omset & Transaksi
        $totalOmset = (clone $completedQuery)->sum('total_price');
        $completedCount = (clone $completedQuery)->count();
        $totalOrdersCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        // 2. Breakdown Metode Pembayaran
        $omsetTunai = (clone $completedQuery)->whereIn('payment_method', ['Tunai', 'CASH', 'Cash'])->sum('total_price');
        $omsetQris = (clone $completedQuery)->whereIn('payment_method', ['QRIS', 'Transfer', 'TRANSFER'])->sum('total_price');

        // 3. Breakdown Tipe Pesanan (POS Walk-in vs Online Web)
        // Note: Cek berdasarkan order_number 'WALK-' atau shipping_address/type
        $omsetWalkin = (clone $completedQuery)->where(function ($q) {
            $q->where('order_number', 'LIKE', 'WALK-%')
                ->orWhere('shipping_address', 'LIKE', '%Walk-in%');
        })->sum('total_price');

        $omsetOnline = $totalOmset - $omsetWalkin;

        // 4. Data Grafik Omset Harian
        $chartData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartTotals = $chartData->pluck('total');

        // 5. Produk Best Seller
        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        // 6. Transaksi Terbaru
        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.owner', compact(
            'totalOmset',
            'totalOrdersCount',
            'completedCount',
            'omsetTunai',
            'omsetQris',
            'omsetWalkin',
            'omsetOnline',
            'bestSellers',
            'recentOrders',
            'startDate',
            'endDate',
            'chartLabels',
            'chartTotals'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // Data Laporan
        $orders = Order::with('items.product', 'user')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalOmset = $orders->sum('total_price');
        $omsetTunai = $orders->whereIn('payment_method', ['Tunai', 'CASH', 'Cash'])->sum('total_price');
        $omsetQris = $orders->whereIn('payment_method', ['QRIS', 'Transfer', 'TRANSFER'])->sum('total_price');

        // Format Nama File Dinamis
        $fileName = 'Laporan Penjualan (' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y') . ').pdf';

        $pdf = Pdf::loadView('reports.sales_pdf', compact('orders', 'totalOmset', 'omsetTunai', 'omsetQris', 'startDate', 'endDate'));

        return $pdf->download($fileName);
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $orders = Order::with('items.product', 'user')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalOmset = $orders->sum('total_price');
        $omsetTunai = $orders->whereIn('payment_method', ['Tunai', 'CASH', 'Cash'])->sum('total_price');
        $omsetQris = $orders->whereIn('payment_method', ['QRIS', 'Transfer', 'TRANSFER'])->sum('total_price');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul Utama
        $sheet->setCellValue('A1', 'ENDORPHINE FLORIST');
        $sheet->setCellValue('A2', 'LAPORAN REKAPITULASI PENJUALAN & KEUANGAN');
        $sheet->setCellValue('A3', 'Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DB2777'));
        $sheet->getStyle('A2:A3')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Ringkasan Keuangan
        $sheet->setCellValue('A5', 'Total Omset');
        $sheet->setCellValue('B5', $totalOmset);
        $sheet->setCellValue('A6', 'Pemasukan Tunai');
        $sheet->setCellValue('B6', $omsetTunai);
        $sheet->setCellValue('A7', 'Pemasukan QRIS');
        $sheet->setCellValue('B7', $omsetQris);

        $sheet->getStyle('A5:A7')->getFont()->setBold(true);
        $sheet->getStyle('B5:B7')->getNumberFormat()->setFormatCode('Rp #,##0');

        // Header Tabel
        $headers = ['No', 'No. Order', 'Tanggal Transaksi', 'Nama Pelanggan', 'Metode Bayar', 'Total Transaksi'];
        $sheet->fromArray($headers, NULL, 'A9');

        // Style Header Tabel (Warna Pink)
        $sheet->getStyle('A9:F9')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet->getStyle('A9:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DB2777');
        $sheet->getStyle('A9:F9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Data Transaksi
        $row = 10;
        foreach ($orders as $index => $ord) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, '#' . $ord->order_number);
            $sheet->setCellValue('C' . $row, $ord->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('D' . $row, $ord->customer_name ?? $ord->user->name ?? 'Walk-in');
            $sheet->setCellValue('E' . $row, strtoupper($ord->payment_method));
            $sheet->setCellValue('F' . $row, $ord->total_price);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('Rp #,##0');

            $row++;
        }

        // Border Tabel Data
        $lastRow = $row - 1;
        if ($lastRow >= 10) {
            $sheet->getStyle('A9:F' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        }

        // Otomatis Lebarkan Kolom Sesuai Isi Teks (Anti Kolom Sempit / ######)
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download File .xlsx
        $fileName = 'Laporan Penjualan (' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y') . ').xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function reports(Request $request)
    {
        $data = $this->buildReportData($request);

        return view('owner.reports', $data);
    }

    public function chart(Request $request)
    {
        $data = $this->buildReportData($request);

        return view('owner.reports-chart', $data);
    }

    private function buildReportData(Request $request): array
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $ordersQuery = Order::with('user')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $totalOmset = (clone $ordersQuery)->sum('total_price');
        $omsetToko = (clone $ordersQuery)->whereIn('payment_method', ['Cash', 'Tunai', 'QRIS Kasir'])->sum('total_price');
        $omsetWeb = $totalOmset - $omsetToko;

        $dailyChart = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $dailyChart->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d');
        });
        $chartTotals = $dailyChart->pluck('total');

        $orders = $ordersQuery->latest()->get();

        return compact(
            'totalOmset',
            'omsetToko',
            'omsetWeb',
            'orders',
            'startDate',
            'endDate',
            'chartLabels',
            'chartTotals'
        );
    }
}