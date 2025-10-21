<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\KeranjangController;


// LANDING PAGE (Tampilan awal user & admin)

Route::get('/', [LandingPageController::class, 'admin']);
// Route::get('/dashboard', [LandingPageController::class, 'user']);


// LOGIN

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware(['isAdmin'])->group(function () {

     Route::get('/dashboard', [DashboardAdminController::class, 'index']);


  Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // KATEGORI

        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


        // USER

        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // ORDER

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');


});

// ROUTE UNTUK ADMIN
// Route::middleware(['web', 'auth', 'isadmin'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
//         // DASHBOARD
//         Route::get('/dashboard', function () {
//             return view('admin.dashboard');
//         })->name('dashboard');

//         // PRODUK
//         Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
//         Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
//         Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
//         Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
//         Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
//         Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

//         // KATEGORI

//         Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
//         Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
//         Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
//         Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
//         Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
//         Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


//         // USER

//         Route::get('/user', [UserController::class, 'index'])->name('user.index');
//         Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
//         Route::post('/user', [UserController::class, 'store'])->name('user.store');
//         Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
//         Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
//         Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

//         // ORDER

//         Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//         Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

//         // KERANJANG

//         Route::get('/keranjangs', [KeranjangController::class, 'index'])->name('keranjang.index');
//         Route::get('/keranjangs/create', [KeranjangController::class, 'create'])->name('keranjang.create');
//         Route::post('/keranjangs', [KeranjangController::class, 'store'])->name('keranjang.store');
//         Route::delete('/keranjangs/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
//         Route::post('/keranjang/add', [KeranjangController::class, 'addToCart'])->name('keranjang.add');
//     });


//     Route::middleware(['auth'])->group(function () {
//     Route::get('/customer/dashboard', function () {
//         return view('customer.dashboard');
//     })->name('customer.dashboard');
// });

// Route::get('/cek-middleware', function () {
//     $route = app('router')->getRoutes()->getByName('admin.dashboard');
//     return $route ? $route->gatherMiddleware() : 'Route not found';
// });

