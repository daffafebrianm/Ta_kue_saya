<?php

namespace App\Providers;

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

        Paginator::useBootstrapFive();

        // View composer untuk view utama user
        View::composer('user.layouts.main', function ($view) {

            // Produk terbaru
            $produks = Produk::aktif()->latest()->take(12)->get();

            // Jumlah item keranjang user yang login
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = Keranjang::where('user_id', auth()->id())->count();
            }

            // Kirim data ke view
            $view->with([
                'produks' => $produks,
                'cartCount' => $cartCount,
            ]);
        });
    }
}
