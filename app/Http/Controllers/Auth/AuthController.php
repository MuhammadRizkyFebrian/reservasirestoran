<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan\Pelanggan;
use App\Models\Staf_Restoran\StafRestoran;
use App\Models\Pelanggan\PasswordResetOtp;
use App\Mail\ResetPasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Admin Authentication
    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Customer Authentication
    public function showCustomerLoginForm()
    {
        return view('auth.login');
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
            return redirect()->route('staf.dashboard');
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
        return view('auth.register');
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
        return view('auth.lupa-sandi');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pelanggan,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to database
        PasswordResetOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'kode_otp' => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(15)
            ]
        );

        // Send OTP via email
        Mail::to($request->email)->send(new ResetPasswordOtp($otp));

        return back()
            ->with('status', 'Kode OTP telah dikirim ke email Anda.')
            ->with('email', $request->email)
            ->with('show_otp_form', true);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pelanggan,email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $passwordReset = PasswordResetOtp::where('email', $request->email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset || !Hash::check($request->otp, $passwordReset->kode_otp)) {
            return back()
                ->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])
                ->with('show_otp_form', true);
        }

        $pelanggan = Pelanggan::where('email', $request->email)->first();
        $pelanggan->password = Hash::make($request->password);
        $pelanggan->save();

        $passwordReset->delete();

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
