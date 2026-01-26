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
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu');

        $startDate = null;
        $endDate = null;

        // 🔹 Hitung range tanggal minggu dalam bulan yang dipilih
        if ($bulan && $minggu) {
            // Awal bulan
            $awalBulan = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'Asia/Jakarta');
            // Hitung tanggal mulai minggu ke-n (Senin)
            $startDate = $awalBulan->copy()->addWeeks($minggu - 1)->startOfWeek(Carbon::MONDAY);
            // Hitung tanggal akhir minggu ke-n (Minggu)
            $endDate = $awalBulan->copy()->addWeeks($minggu - 1)->endOfWeek(Carbon::SUNDAY);

            // Pastikan tidak keluar dari bulan yang sama
            if ($startDate->month != $bulan) {
                $startDate = $awalBulan->copy();
            }
            if ($endDate->month != $bulan) {
                $endDate = $awalBulan->copy()->endOfMonth();
            }
        }

        // 🔹 Query data order sesuai filter
        $query = \App\Models\Order::with(['orderDetails.produk'])
            ->where('payment_status', 'paid')
            ->whereYear('order_date', $tahun);

        // Filter minggu
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        // Filter bulan (jika tidak pilih minggu)
        elseif ($bulan) {
            $query->whereMonth('order_date', $bulan);
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(10);


        // 🔹 Hitung total
        $total_penjualan = 0;
        $total_modal = 0;
        $total_laba = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $total_penjualan += $detail->total ?? ($detail->harga * $detail->jumlah);
                $total_modal += ($detail->harga_modal ?? 0) * $detail->jumlah;
                $total_laba += (($detail->harga ?? 0) - ($detail->harga_modal ?? 0)) * $detail->jumlah;
            }
        }

        return view('admin.keuangan.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu' => $minggu,
            'orders' => $orders,
            'total_penjualan' => $total_penjualan,
            'total_modal' => $total_modal,
            'total_laba' => $total_laba,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
            ->setPaper('a4', 'landscape');

        $periode = $minggu ? "Minggu_$minggu" : ($bulan ?? 'Semua');
        return $pdf->stream("Laporan_Keuangan_{$periode}_{$tahun}.pdf");
    }
}
