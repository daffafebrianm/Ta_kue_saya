<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // KPI
        $todayOrdersCount = Order::whereDate('order_date', $today)->count();
        $totalOrdersCount = Order::count();

        $todayRevenue = (float) Order::whereDate('order_date', $today)
            ->whereIn('payment_status', ['paid', 'success', 'settlement']) // sesuaikan
            ->sum('totalharga');

        $totalRevenue = (float) Order::whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->sum('totalharga');

        // Chart: Revenue per bulan (12 bulan terakhir)
        $monthlyRevenue = Order::selectRaw('DATE_FORMAT(order_date, "%Y-%m") as ym, SUM(totalharga) as total')
            ->whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->where('order_date', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // Chart: Order per status (payment)
        $paymentStatusCounts = Order::select('payment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_status')
            ->orderBy('total', 'desc')
            ->get();

        // Recent Orders (buat tabel kayak gambar)
        $recentOrders = Order::with('user')
            ->orderByDesc('order_date')
            ->limit(8)
            ->get();

        // Quick counts (buat kartu tambahan kalau mau)
        $produkCount = Produk::count();
        $kategoriCount = Kategori::count();

        // Siapkan labels & data chart (hindari hole bulan kosong)
        $labels = [];
        $dataRevenue = [];
        $map = $monthlyRevenue->pluck('total', 'ym');

        for ($i = 11; $i >= 0; $i--) {
            $key = Carbon::now()->subMonths($i)->format('Y-m');
            $labels[] = Carbon::createFromFormat('Y-m', $key)->format('M Y');
            $dataRevenue[] = (float) ($map[$key] ?? 0);
        }

        $statusLabels = $paymentStatusCounts->pluck('payment_status')->map(fn ($s) => ucfirst($s))->toArray();
        $statusData = $paymentStatusCounts->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        return view('admin.dashboard', compact(
            'todayOrdersCount',
            'totalOrdersCount',
            'todayRevenue',
            'totalRevenue',
            'recentOrders',
            'produkCount',
            'kategoriCount',
            'labels',
            'dataRevenue',
            'statusLabels',
            'statusData'
        ));
    }
}
