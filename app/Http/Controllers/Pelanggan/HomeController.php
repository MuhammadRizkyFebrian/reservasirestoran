<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Staf_Restoran\Menu;
use App\Models\Pelanggan\Pemesanan;
use App\Models\Pelanggan\Ulasan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::inRandomOrder()->take(6)->get();
        $isLoggedIn = Auth::guard('pelanggan')->check();
        $user = Auth::guard('pelanggan')->user();

        $ulasans = Ulasan::with('pelanggan')
            ->orderBy('id', 'desc')
            ->get();

        $avgRating = number_format(
            Ulasan::avg('star_rating'),
            1
        );

        $totalReviews = Ulasan::count();

        $lastOrder = $isLoggedIn
            ? Pemesanan::where('id_pelanggan', $user->id_pelanggan)
            ->orderBy('jadwal', 'desc')
            ->first()
            : null;

        return view('pelanggan.home', compact(
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
