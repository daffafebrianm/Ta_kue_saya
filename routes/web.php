<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\user\CekOutController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\user\AboutUsController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\user\LocationController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\user\PembayaranController;
use App\Http\Controllers\admin\BarangMasukController;
use App\Http\Controllers\user\DetailProdukController;
use App\Http\Controllers\user\ProductKatalogController;
use App\Http\Controllers\user\RiwayatPesananController;
use App\Http\Controllers\Admin\DashboardAdminController;

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
    Route::get('/produk/laporan-pdf', [ProdukController::class, 'cetakPDF'])->name('produk.pdf');
    Route::get('/barang-masuk/laporan-pdf', [BarangMasukController::class, 'cetakPDF'])->name('barang-masuk.pdf');
    Route::get('/keuangan/laporan-pdf', [KeuanganController::class, 'cetakPDF'])->name('Keuangan.pdf');
    Route::get('/orders/laporan-pdf', [OrderController::class, 'cetakPDF'])->name('orders.pdf');

    Route::resource('/produk', ProdukController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/barang-masuk', BarangMasukController::class);

    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');

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


    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'addToCart'])->name('keranjang.store');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::delete('/keranjang', [KeranjangController::class, 'clear'])->name('keranjang.clear');
    // 🔥 Tambahan: route untuk hitung jumlah item keranjang (real-time)
    Route::get('/keranjang/count', function () {
        if (auth()->check()) {
            $count = \App\Models\Keranjang::where('user_id', auth()->id())->count();
            return response()->json(['count' => $count]);
        }
        return response()->json(['count' => 0]);
    })->name('keranjang.count');



    Route::get('/Payment/{orderId}', [PembayaranController::class, 'index'])->name('Pembayaran.index');
    Route::get('/Payment/success/{orderId}', [PembayaranController::class, 'success'])->name('Pembayaran.success');
    Route::get('/Payment/cancel/{orderId}', [PembayaranController::class, 'cancel'])->name('Pembayaran.cancel');


    Route::get('/Checkout', [CekOutController::class, 'index'])->name('Checkout.index');
    Route::post('/Checkout', [CekOutController::class, 'store'])->name('Checkout.store');

    Route::get('/Profile', [ProfileController::class, 'index'])->name('Profile.index');
    Route::put('/Profile', [ProfileController::class, 'update'])->name('Profile.update');

    Route::get('/Riwayat-Pesanan', [RiwayatPesananController::class, 'index'])->name('Riwayat.index');

    Route::get('/about_us', [AboutUsController::class, 'index'])->name('about.index');
    Route::get('/location', [LocationController::class, 'index'])->name('location.index');


    // =========================

    // // Inisiasi bayar (redirect ke gateway / buat VA/QR)
    // Route::post('/payments/{order}', [PaymentController::class, 'pay'])->name('payments.pay');

    // // Callback URL setelah kembali dari gateway (sukses/gagal)
    // Route::get('/payments/{order}/success', [PaymentController::class, 'success'])->name('payments.success');
    // Route::get('/payments/{order}/failed', [PaymentController::class, 'failed'])->name('payments.failed');
});

Route::get('/products', [ProductKatalogController::class, 'index'])->name('products.index');

Route::get('/detail-products/{id}', [DetailProdukController::class, 'index'])->name('detail.index');
Route::get('/detail-products/{slug}', [ProductKatalogController::class, 'index'])->name('prpduct.index');

Route::get('/about_us', [AboutUsController::class, 'index'])->name('about.index');
Route::get('/location', [LocationController::class, 'index'])->name('location.index');
