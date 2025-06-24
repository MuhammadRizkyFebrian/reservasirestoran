<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('profile', compact('pelanggan'));
    }

    public function update(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'username' => 'nullable|unique:pelanggan,username,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'email' => 'nullable|email|unique:pelanggan,email,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'nomor_handphone' => 'nullable|numeric|unique:pelanggan,nomor_handphone,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nomor_handphone.numeric' => 'Nomor handphone harus berupa angka.',
            'nomor_handphone.unique' => 'Nomor handphone sudah terdaftar.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $data = [];

        if ($request->filled('username')) {
            $data['username'] = $request->username;
        }
        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }
        if ($request->filled('nomor_handphone')) {
            $data['nomor_handphone'] = $request->nomor_handphone;
        }

        if ($request->hasFile('foto_profil')) {
            if ($pelanggan->foto_profil != 'default.jpg' && Storage::disk('public')->exists('profile/' . $pelanggan->foto_profil)) {
                Storage::disk('public')->delete('profile/' . $pelanggan->foto_profil);
            }

            $fotoPath = $request->file('foto_profil')->store('profile', 'public');
            $data['foto_profil'] = basename($fotoPath);
        }

        if (!empty($data)) {
            $pelanggan->update($data);
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function reservationHistory()
    {
        // Menggunakan id_pelanggan yang benar untuk relasi
        $pelanggan = Auth::guard('pelanggan')->user();
        
        $reservasi = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->orderByDesc('jadwal')
            ->get();

        return view('reservation-history', compact('reservasi'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $pelanggan = Auth::guard('pelanggan')->user();

        if (!Hash::check($request->current_password, $pelanggan->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $pelanggan->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui!');
    }
}