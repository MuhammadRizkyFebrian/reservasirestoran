<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::inRandomOrder()->take(6)->get();

        $isLoggedIn = Auth::guard('pelanggan')->check();
        $user = Auth::guard('pelanggan')->user();

        return view('home', compact('menus', 'isLoggedIn', 'user'));
    }
} 