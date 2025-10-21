<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function admin()
    {
        return view('admin.Dashboard');
    }

    public function user()
    {
        return view('user.layouts.main');
    }
}
