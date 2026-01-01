<?php

use App\Http\Controllers\user\PembayaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/midtrans/callback', [PembayaranController::class, 'callback'])
->name('midtrans.callback');
