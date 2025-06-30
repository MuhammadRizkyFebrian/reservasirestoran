<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::inRandomOrder()->take(6)->get();
        $isLoggedIn = Auth::guard('pelanggan')->check();
        $user = Auth::guard('pelanggan')->user();

        $ulasans = Ulasan::where('status', 'active')
            ->latest()
            ->with('pelanggan')
            ->get();

        $avgRating = number_format(
            Ulasan::where('status', 'active')->avg('star_rating'),
            1
        );

        $totalReviews = Ulasan::where('status', 'active')->count();

        $lastOrder = $isLoggedIn
            ? Pesanan::where('id_pelanggan', $user->id_pelanggan)
            ->orderBy('jadwal', 'desc')
            ->first()
            : null;

        return view('home', compact(
            'menus',
            'isLoggedIn',
            'user',
            'ulasans',
            'avgRating',
            'totalReviews',
            'lastOrder'
        ));
    }
}
