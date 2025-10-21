<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function admin()
    {
        return view('admin.layouts.main');
    }

    public function user()
    {
        return view('user.layouts.main');
    }
}
