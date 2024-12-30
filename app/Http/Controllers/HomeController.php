<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $themes = Theme::select('id', 'name')->where('status',1)->get();
        return view('dashboard', compact('themes'));
    }
}

