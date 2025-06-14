<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\StafRestoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelangganAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek staf_restoran dulu
        $staf = StafRestoran::where('username', $request->username)->first();
        if ($staf && \Hash::check($request->password, $staf->password)) {
            \Auth::guard('staf')->login($staf); 
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Cek pelanggan
        $pelanggan = Pelanggan::where('username', $request->username)->first();
        if ($pelanggan && \Hash::check($request->password, $pelanggan->password)) {
            $remember = $request->has('remember');
            \Auth::guard('pelanggan')->login($pelanggan, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['loginError' => 'Username atau password salah.']);
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pelanggan',
            'email' => 'required|email|unique:pelanggan',
            'nomor_handphone' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        Pelanggan::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_handphone' => $request->nomor_handphone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        } else {
            Auth::logout(); // Untuk admin
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
