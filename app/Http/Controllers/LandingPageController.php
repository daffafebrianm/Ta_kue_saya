<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function admin()
    {
        return view('admin.Dashboard');
    }

    public function user()
    {
        $produks = Produk::aktif()->latest()->take(12)->get();
        return view('user.home', compact('produks'));
    }
}
