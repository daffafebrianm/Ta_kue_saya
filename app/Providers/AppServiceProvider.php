<?php

namespace App\Providers;

use App\Models\Produk;
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
        Paginator::useBootstrapFive();
    View::composer('user.layouts.main', function ($view) {
        $view->with('produks', Produk::aktif()->latest()->take(12)->get());
    });
    }
}
