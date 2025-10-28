<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\User\KeranjangController;
use Illuminate\Support\Facades\Route;

// LANDING PAGE (Tampilan awal user & admin)

Route::get('/', [LandingPageController::class, 'user'])->name('landing');
// Route::get('/dashboard', [LandingPageController::class, 'user']);
// LOGIN

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['isAdmin'])->group(function () {

    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    Route::resource('/produk', ProdukController::class);
    Route::resource('/kategori', KategoriController::class);

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // ORDER
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

Route::middleware(['isCustomer'])->group(function () {
    // =========================
    // PRODUK (browse & detail)
    // =========================
    Route::get('/products', [\App\Http\Controllers\user\ProdukController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [\App\Http\Controllers\user\ProdukController::class, 'show'])->name('products.show');

    // =========================
    // KERANJANG
    // =========================
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'addToCart'])->name('keranjang.store');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::delete('/keranjang', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    // =========================
    // CHECKOUT & PEMBAYARAN
    // =========================
    // Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');  // Form alamat/metode bayar
    // Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');   // Buat Order

    // // Inisiasi bayar (redirect ke gateway / buat VA/QR)
    // Route::post('/payments/{order}', [PaymentController::class, 'pay'])->name('payments.pay');

    // // Callback URL setelah kembali dari gateway (sukses/gagal)
    // Route::get('/payments/{order}/success', [PaymentController::class, 'success'])->name('payments.success');
    // Route::get('/payments/{order}/failed', [PaymentController::class, 'failed'])->name('payments.failed');
});

//     Route::middleware(['auth'])->group(function () {
//     Route::get('/customer/dashboard', function () {
//         return view('customer.dashboard');
//     })->name('customer.dashboard');
// });

// Route::get('/cek-middleware', function () {
//     $route = app('router')->getRoutes()->getByName('admin.dashboard');
//     return $route ? $route->gatherMiddleware() : 'Route not found';
// });
