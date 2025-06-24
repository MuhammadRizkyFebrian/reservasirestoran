<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ulasan;
use App\Models\Pelanggan;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::inRandomOrder()->take(6)->get();
        $isLoggedIn = Auth::guard('pelanggan')->check();
        $user = Auth::guard('pelanggan')->user();

        // Ambil ulasan aktif
        $ulasans = Ulasan::where('status', 'active')->latest()->with('pelanggan')->get();

        // Hitung rating rata-rata dan total ulasan
        $avgRating = number_format(Ulasan::where('status', 'active')->avg('star_rating'), 1);
        $totalReviews = Ulasan::where('status', 'active')->count();

        return view('home', compact('menus', 'isLoggedIn', 'user', 'ulasans', 'avgRating', 'totalReviews'));
    }
} 