<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\StafRestoran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Admin Authentication
    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ]);
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // Customer Authentication
    public function showCustomerLoginForm()
    {
        return view('login');
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek staf_restoran
        $staf = StafRestoran::where('username', $request->username)->first();
        if ($staf && Hash::check($request->password, $staf->password)) {
            Auth::guard('staf')->login($staf);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Cek pelanggan
        $pelanggan = Pelanggan::where('username', $request->username)->first();
        if ($pelanggan && Hash::check($request->password, $pelanggan->password)) {
            $remember = $request->has('remember');
            Auth::guard('pelanggan')->login($pelanggan, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['loginError' => 'Username atau password salah.']);
    }

    public function customerLogout(Request $request)
    {
        if (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pelanggan,username',
            'email' => 'required|email|unique:pelanggan,email',
            'nomor_handphone' => 'required|numeric|unique:pelanggan,nomor_handphone',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nomor_handphone.required' => 'Nomor handphone wajib diisi.',
            'nomor_handphone.numeric' => 'Nomor handphone harus berupa angka.',
            'nomor_handphone.unique' => 'Nomor handphone sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Pelanggan::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_handphone' => $request->nomor_handphone,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Password Reset
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:pelanggan,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pelanggan = Pelanggan::where('email', $request->email)->first();
        $pelanggan->password = Hash::make($request->password);
        $pelanggan->save();

        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login.');
    }
}
