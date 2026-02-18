<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal'); // 🔹 HARlAN
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu');

        $startDate = null;
        $endDate = null;

        // 🔹 Hitung range tanggal minggu dalam bulan yang dipilih
        if (! $tanggal && $bulan && $minggu) {
            $awalBulan = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'Asia/Jakarta');

            $startDate = $awalBulan->copy()
                ->addWeeks($minggu - 1)
                ->startOfWeek(Carbon::MONDAY);

            $endDate = $awalBulan->copy()
                ->addWeeks($minggu - 1)
                ->endOfWeek(Carbon::SUNDAY);

            // Pastikan tidak keluar dari bulan yang sama
            if ($startDate->month != $bulan) {
                $startDate = $awalBulan->copy();
            }
            if ($endDate->month != $bulan) {
                $endDate = $awalBulan->copy()->endOfMonth();
            }
        }

        // 🔹 Query data order sesuai filter
        $query = Order::with(['orderDetails.produk'])
            ->where('payment_status', 'paid');

        // 🔹 PRIORITAS 1: Harian
        if ($tanggal) {

            // jika bulan tidak dipilih, pakai bulan sekarang
            $bulan = $bulan ?: date('n');

            // jika tahun tidak dipilih, pakai tahun sekarang
            $tahun = $tahun ?: date('Y');

            $tanggalFull = Carbon::createFromDate($tahun, $bulan, $tanggal)->format('Y-m-d');

            $query->whereDate('order_date', $tanggalFull);

        } else {

            // 🔹 Tahunan
            if ($tahun) {
                $query->whereYear('order_date', $tahun);
            }

            // 🔹 Mingguan
            if ($startDate && $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            }
            // 🔹 Bulanan (jika tidak pilih minggu)
            elseif ($bulan) {
                $query->whereMonth('order_date', $bulan);
            }
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(10);

        // 🔹 Hitung total
        $total_penjualan = 0;
        $total_modal = 0;
        $total_laba = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $total_penjualan += $detail->total ?? (($detail->harga ?? 0) * ($detail->jumlah ?? 0));
                $total_modal += ($detail->harga_modal ?? 0) * ($detail->jumlah ?? 0);
                $total_laba += (($detail->harga ?? 0) - ($detail->harga_modal ?? 0)) * ($detail->jumlah ?? 0);
            }
        }

        return view('admin.keuangan.index', [
            'tanggal' => $tanggal,
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

    // ======================================================

    public function cetakPdf(Request $request)
    {
        $tanggal = $request->input('tanggal'); // 🔹 HARlAN
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));
        $minggu = $request->input('minggu');

        $startDate = null;
        $endDate = null;

        // 🔹 Hitung range tanggal minggu dalam bulan yang dipilih
        if (! $tanggal && $bulan && $minggu) {
            $awalBulan = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'Asia/Jakarta');

            $startDate = $awalBulan->copy()
                ->addWeeks($minggu - 1)
                ->startOfWeek(Carbon::MONDAY);

            $endDate = $awalBulan->copy()
                ->addWeeks($minggu - 1)
                ->endOfWeek(Carbon::SUNDAY);

            if ($startDate->month != $bulan) {
                $startDate = $awalBulan->copy();
            }

            if ($endDate->month != $bulan) {
                $endDate = $awalBulan->copy()->endOfMonth();
            }
        }

        // 🔹 Ambil semua order berdasarkan filter
        $query = Order::with(['orderDetails.produk'])
            ->where('payment_status', 'paid');

        // 🔹 PRIORITAS 1: Harian
        if ($tanggal) {

            $bulan = $bulan ?: date('n');
            $tahun = $tahun ?: date('Y');

            $tanggalFull = Carbon::createFromDate($tahun, $bulan, $tanggal)->format('Y-m-d');

            $query->whereDate('order_date', $tanggalFull);

        } else {
    
            // 🔹 Tahunan
            if ($tahun) {
                $query->whereYear('order_date', $tahun);
            }

            // 🔹 Mingguan
            if ($startDate && $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            }
            // 🔹 Bulanan
            elseif ($bulan) {
                $query->whereMonth('order_date', $bulan);
            }
        }

        $orders = $query->orderBy('order_date', 'asc')->get();

        // 🔹 Hitung total
        $total_penjualan = 0;
        $total_modal = 0;
        $total_laba = 0;

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $total_penjualan += $detail->total ?? (($detail->harga ?? 0) * ($detail->jumlah ?? 0));
                $total_modal += ($detail->harga_modal ?? 0) * ($detail->jumlah ?? 0);
                $total_laba += (($detail->harga ?? 0) - ($detail->harga_modal ?? 0)) * ($detail->jumlah ?? 0);
            }
        }

        $data = [
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'minggu' => $minggu,
            'orders' => $orders,
            'total_penjualan' => $total_penjualan,
            'total_modal' => $total_modal,
            'total_laba' => $total_laba,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $pdf = Pdf::loadView('admin.keuangan.laporan', $data)
            ->setPaper('a4', 'landscape');

        // 🔹 Nama file dinamis
        if ($tanggal) {
            $periode = Carbon::parse($tanggal)->format('d-m-Y');
        } elseif ($minggu) {
            $periode = "Minggu_$minggu";
        } elseif ($bulan) {
            $periode = "Bulan_$bulan";
        } else {
            $periode = "Tahun_$tahun";
        }

        return $pdf->stream("Laporan_Keuangan_{$periode}_{$tahun}.pdf");
    }
}
