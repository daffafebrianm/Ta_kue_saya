<?php

use App\Http\Controllers\admin\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/produk', [ProdukCOntroller::class,'store']);
Route::post('/produk/{id}',[ProdukCOntroller::class,'update']);
Route::delete('/produk/{id}', [ProdukCOntroller::class, 'destroy']);
