<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan, tahun, dan minggu
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu'); // opsional, untuk filter mingguan

        // Tentukan rentang tanggal minggu jika minggu dipilih (berdasarkan kalender Indonesia)
        $startDate = null;
        $endDate = null;

        if ($minggu) {
            // Gunakan minggu kalender (ISO week) sesuai zona waktu Indonesia
            $startDate = Carbon::now('Asia/Jakarta')->setISODate($tahun, $minggu)->startOfWeek(Carbon::MONDAY);
            $endDate = Carbon::now('Asia/Jakarta')->setISODate($tahun, $minggu)->endOfWeek(Carbon::SUNDAY);
        }

        // Query dasar
        $query = OrderDetail::select(
            DB::raw('SUM(total) as total_penjualan'),
            DB::raw('SUM(harga_modal * jumlah) as total_modal'),
            DB::raw('SUM((harga - harga_modal) * jumlah) as total_laba')
        )
            ->whereHas('order', function ($q) use ($tahun, $bulan, $startDate, $endDate) {
                $q->whereYear('order_date', $tahun)
                    ->where('payment_status', 'paid');

                if ($bulan) {
                    $q->whereMonth('order_date', $bulan);
                }

                if ($startDate && $endDate) {
                    $q->whereBetween('order_date', [$startDate, $endDate]);
                }
            });

        $result = $query->first();

        return view('admin.keuangan.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu' => $minggu,
            'total_penjualan' => $result->total_penjualan ?? 0,
            'total_modal' => $result->total_modal ?? 0,
            'total_laba' => $result->total_laba ?? 0,
        ]);
    }

    public function cetakPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu');

        // Tentukan rentang tanggal minggu jika minggu dipilih (berdasarkan kalender Indonesia)
        $startDate = null;
        $endDate = null;

        if ($minggu) {
            $startDate = Carbon::now('Asia/Jakarta')->setISODate($tahun, $minggu)->startOfWeek(Carbon::MONDAY);
            $endDate = Carbon::now('Asia/Jakarta')->setISODate($tahun, $minggu)->endOfWeek(Carbon::SUNDAY);
        }

        // Ambil semua order berdasarkan filter
        $orders = \App\Models\Order::with(['orderDetails.produk'])
            ->whereYear('order_date', $tahun)
            ->where('payment_status', 'paid')
            ->when($bulan, fn($q) => $q->whereMonth('order_date', $bulan))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('order_date', [$startDate, $endDate]))
            ->orderBy('order_date', 'asc')
            ->get();

        // Hitung total
        $total_penjualan = 0;
        $total_modal = 0;
        $total_laba = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $total_penjualan += $detail->total;
                $total_modal += $detail->harga_modal * $detail->jumlah;
                $total_laba += ($detail->harga - $detail->harga_modal) * $detail->jumlah;
            }
        }

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu' => $minggu,
            'orders' => $orders,
            'total_penjualan' => $total_penjualan,
            'total_modal' => $total_modal,
            'total_laba' => $total_laba,
        ];

        $pdf = Pdf::loadView('admin.keuangan.laporan', $data)
            ->setPaper('a4', 'portrait');

        $periode = $minggu ? "Minggu_$minggu" : ($bulan ?? 'Semua');
        return $pdf->stream("Laporan_Keuangan_{$periode}_{$tahun}.pdf");
    }
}
