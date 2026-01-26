<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        //         if (app()->environment('local')) {
        //     URL::forceScheme('https');
        // }

        // Mengirim $notifikasiOrders ke semua view yang memakai 'admin.*'
        View::composer('admin.*', function ($view) {
            $notifikasiOrders = Order::select('id', 'order_code', 'nama', 'shipping_status', 'created_at')
                ->where('shipping_status', 'processing')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $view->with('notifikasiOrders', $notifikasiOrders);
        });
        Paginator::useBootstrap();

        // View composer untuk view utama user
        View::composer('user.layouts.main', function ($view) {

            // Ambil produk terbaru (12 produk terakhir)
            $produks = Produk::aktif()->latest()->take(12)->get();

            // Hitung jumlah produk unik di keranjang user yang login
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = Keranjang::where('user_id', auth()->id())
                    ->distinct('produk_id') // Hanya produk unik
                    ->count('produk_id');
            }

            // Kirim data ke view
            $view->with([
                'produks'  => $produks,
                'cartCount' => $cartCount,
            ]);
        });

    }
}
