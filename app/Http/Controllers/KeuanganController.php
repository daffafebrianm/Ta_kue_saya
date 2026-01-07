<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan & tahun
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        // Query dasar
        $query = OrderDetail::select(
            DB::raw('SUM(total) as total_penjualan'),
            DB::raw('SUM(harga_modal * jumlah) as total_modal'),
            DB::raw('SUM((harga - harga_modal) * jumlah) as total_laba')
        )
            ->whereHas('order', function ($q) use ($tahun, $bulan) {
                $q->whereYear('order_date', $tahun);
                if ($bulan) {
                    $q->whereMonth('order_date', $bulan);
                }
                $q->where('payment_status', 'paid');
            });

        $result = $query->first();

        return view('admin.Keuangan.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_penjualan' => $result->total_penjualan ?? 0,
            'total_modal' => $result->total_modal ?? 0,
            'total_laba' => $result->total_laba ?? 0,
        ]);
    }
    public function cetakPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));

        // 🔹 Ambil semua order yang sudah dibayar dalam periode tsb
        $orders = \App\Models\Order::with(['orderDetails.produk'])
            ->whereYear('order_date', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('order_date', $bulan))
            ->where('payment_status', 'paid')
            ->orderBy('order_date', 'asc')
            ->get();

        // 🔹 Hitung total keseluruhan
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

        // 🔹 Siapkan data ke view
        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'orders' => $orders,
            'total_penjualan' => $total_penjualan,
            'total_modal' => $total_modal,
            'total_laba' => $total_laba,
        ];

        // 🔹 Buat PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.keuangan.laporan', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Keuangan_' . ($bulan ?? 'Semua') . '_' . $tahun . '.pdf');
    }
}
