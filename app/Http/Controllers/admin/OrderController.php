<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Psy\Command\WhereamiCommand;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $bulan  = $request->input('bulan');
        $tahun  = $request->input('tahun');

        // 🔹 Jika user belum pilih bulan/tahun, redirect ke bulan & tahun sekarang
        if (!$bulan && !$tahun) {
            return redirect()->route('orders.index', [
                'bulan' => date('n'),
                'tahun' => date('Y'),
            ]);
        }

        $orders = Order::with('user')
            ->when($search, function ($query, $search) {
                $query->where('order_code', 'like', "%{$search}%");
            })
            ->when($bulan, function ($query, $bulan) {
                $query->whereMonth('order_date', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                $query->whereYear('order_date', $tahun);
            })
            ->where('payment_status', 'paid')
            ->orderBy('order_date', 'desc')
            ->paginate(10)
            ->appends([
                'search' => $search,
                'bulan'  => $bulan,
                'tahun'  => $tahun,
            ]);

        return view('admin.Order.index', compact('orders', 'search', 'bulan', 'tahun'));
    }



    public function show($id)
    {
        $order = Order::with('user', 'orderDetails.produk')->findOrFail($id);
        return view('admin.Order.show', compact('order'));
    }



    public function cetakPDF(Request $request)
    {
        $bulan = $request->query('bulan'); // 1 - 12
        $tahun = $request->query('tahun'); // 2026, dll.

        // Hitung tanggal awal & akhir bulan yang dipilih
        if ($bulan && $tahun) {
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString(); // Y-m-d
            $endDate   = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query order yang sudah dibayar beserta relasi detail dan produk
        $orders = Order::with('orderDetails.produk')
            ->where('payment_status', 'paid')
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('order_date', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('order_date', '<=', $endDate);
            })
            ->orderBy('order_date', 'asc')
            ->get();

        // Hitung ringkasan keuangan
        $total_penjualan = $orders->sum('totalharga');
        $total_modal = $orders->sum(function ($order) {
            return $order->orderDetails->sum(function ($detail) {
                return $detail->harga_modal * $detail->jumlah;
            });
        });
        $total_laba = $orders->sum(function ($order) {
            return $order->orderDetails->sum(function ($detail) {
                return $detail->total - ($detail->harga_modal * $detail->jumlah);
            });
        });

        // Load view PDF dan kirim data ke dalamnya
        $pdf = Pdf::loadView('admin.Order.laporan', compact(
            'orders',
            'total_penjualan',
            'total_modal',
            'total_laba',
            'bulan',
            'tahun'
        ))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_order_paid.pdf');
    }
    public function updateShippingStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $newStatus = $request->input('shipping_status');

        $allowedTransitions = [
            'pending' => ['processing'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['completed'],
            'completed' => [], // tidak bisa diubah lagi
            'cancelled' => []  // tidak bisa diubah lagi
        ];

        $currentStatus = $order->shipping_status;

        // Cek apakah status baru valid berdasarkan status saat ini
        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return back()->with('error', "Status pengiriman tidak dapat diubah dari '{$currentStatus}' ke '{$newStatus}'.");
        }

        // Update status jika valid
        $order->shipping_status = $newStatus;
        $order->save();

        return back()->with('success', "Status pengiriman berhasil diubah menjadi '{$newStatus}'.");
    }
}
