<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        /* ============================================================
            🧾 KPI SECTION
            ============================================================ */
        $todayOrdersCount = Order::where('payment_status', 'paid')
            ->whereDate('order_date', now())
            ->count();

        $monthlyOrdersCount = Order::where('payment_status', 'paid')
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->count();


        $todayRevenue = (float) Order::whereDate('order_date', $today)
            ->whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->sum('totalharga');

        $totalRevenueThisMonth = (float) Order::whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->sum('totalharga');


        /* ============================================================
            🧾 RECENT ORDERS
            ============================================================ */
        $recentOrders = Order::with('user')
            ->where('payment_status', 'paid')
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->orderByDesc('order_date')
            ->limit(10)
            ->get();


        /* ============================================================
            📦 QUICK COUNTS
            ============================================================ */
        $produkCount = Produk::count();
        $kategoriCount = Kategori::count();

        /* ============================================================
            🗓️ LABELS 12 BULAN TERAKHIR
            ============================================================ */
        $labels = [];
        $ymKeys = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');   // untuk chart JS
            $ymKeys[] = $date->format('Y-m');   // untuk mapping data
        }

        /* ============================================================
   🚚 SHIPPING STATUS CHART
   ============================================================ */
        $statuses = ['processing', 'shipped', 'completed'];

        $shippingStatusCounts = Order::select('shipping_status', DB::raw('COUNT(*) as total'))
            ->whereIn('shipping_status', $statuses)
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->groupBy('shipping_status')
            ->get()
            ->keyBy('shipping_status');

        $statusLabels = [];
        $statusData   = [];

        foreach ($statuses as $status) {
            $statusLabels[] = ucfirst($status);
            $statusData[]   = isset($shippingStatusCounts[$status])
                ? (int) $shippingStatusCounts[$status]->total
                : 0;
        }



        /* ============================================================
            📈 REVENUE & ORDER STATS
            ============================================================ */
        $monthlyStats = Order::selectRaw('
                    DATE_FORMAT(order_date, "%Y-%m") as ym,
                    COUNT(*) as total_orders,
                    SUM(totalharga) as total_revenue,
                    AVG(totalharga) as avg_order_value
                ')
            ->whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->where('order_date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $dataRevenue = [];
        $orderCountData = [];
        $avgOrderValueData = [];

        foreach ($ymKeys as $ym) {
            $stats = $monthlyStats[$ym] ?? null;
            $dataRevenue[] = $stats ? (float)$stats->total_revenue : 0;
            $orderCountData[] = $stats ? (int)$stats->total_orders : 0;
            $avgOrderValueData[] = $stats ? (float)$stats->avg_order_value : 0;
        }

        /* ============================================================
        /* 💹 FINANCE CHART (PENJUALAN, MODAL, LABA) */
        $monthlyFinance = OrderDetail::selectRaw('
            DATE_FORMAT(orders.order_date, "%Y-%m") as ym,
            SUM(order_details.total) as total_penjualan,
            SUM(order_details.harga_modal * order_details.jumlah) as total_modal,
            SUM((order_details.harga - order_details.harga_modal) * order_details.jumlah) as total_laba
        ')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereIn('orders.payment_status', ['paid', 'success', 'settlement'])
            ->where('orders.order_date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        // Generate 12 bulan terakhir sebagai key
        $ymKeys = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $ymKey = Carbon::now()->subMonths($i)->format('Y-m');
            $ymKeys[] = $ymKey;
            $labels[] = Carbon::createFromFormat('Y-m', $ymKey)->format('M Y');
        }

        $salesData = [];
        $capitalData = [];
        $profitData = [];

        // Loop untuk mengisi data finance 12 bulan terakhir
        foreach ($ymKeys as $ym) {
            $finance = $monthlyFinance[$ym] ?? null;

            $salesData[] = $finance ? (float) $finance->total_penjualan : 0;
            $capitalData[] = $finance ? (float) $finance->total_modal : 0;
            $profitData[] = $finance ? (float) $finance->total_laba : 0;
        }

        /* ============================================================
   🔹 CEK JIKA SEMUA DATA KOSONG
   Jika semua penjualan, modal, dan laba = 0, ganti label & data
============================================================ */
        if (array_sum($salesData) + array_sum($capitalData) + array_sum($profitData) == 0) {
            $labels = ['Tidak ada data'];  // hanya 1 label
            $salesData = [0];              // satu batang nol
            $capitalData = [0];
            $profitData = [0];
        }

        // dd($labels, $salesData, $capitalData, $profitData);

        /* ============================================================
            🔙 RETURN VIEW
            ============================================================ */
        return view('admin.dashboard', compact(
            'todayOrdersCount',
            'monthlyOrdersCount',
            'todayRevenue',
            'totalRevenueThisMonth',
            'recentOrders',
            'produkCount',
            'kategoriCount',
            'labels',
            'dataRevenue',
            'statusLabels',
            'statusData',
            'orderCountData',
            'avgOrderValueData',
            'salesData',
            'capitalData',
            'profitData'
        ));
    }
}
