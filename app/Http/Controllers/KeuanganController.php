<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
