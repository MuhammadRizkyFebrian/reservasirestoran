<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan\Ulasan;
use App\Models\Pelanggan\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // Create
    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $request->validate([
                'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
                'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
                'comments' => 'required|string|max:100',
                'star_rating' => 'required|integer|min:1|max:5',
            ], [
                'id_pemesanan.required' => 'ID pemesanan wajib diisi.',
                'id_pemesanan.exists' => 'ID pemesanan tidak valid.',
                'id_pelanggan.required' => 'ID pelanggan wajib diisi.',
                'id_pelanggan.exists' => 'ID pelanggan tidak valid.',
                'comments.required' => 'Komentar wajib diisi.',
                'comments.max' => 'Komentar maksimal 100 karakter.',
                'star_rating.required' => 'Rating wajib diisi.',
                'star_rating.integer' => 'Rating harus berupa angka.',
                'star_rating.min' => 'Rating minimal 1.',
                'star_rating.max' => 'Rating maksimal 5.'
            ]);

            // Simpan ke tabel ulasan
            Ulasan::create([
                'id_pemesanan' => $request->id_pemesanan,
                'id_pelanggan' => $request->id_pelanggan,
                'comments' => $request->comments,
                'star_rating' => $request->star_rating,
                'status' => 'active',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil ditambahkan!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);

        // Pastikan hanya pemilik ulasan yang bisa menghapus
        if ($ulasan->id_pelanggan != auth()->guard('pelanggan')->user()->id_pelanggan) {
            abort(403, 'Tidak diizinkan menghapus ulasan ini.');
        }

        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ulasan,id',
            'comments' => 'required|string|max:100',
            'star_rating' => 'required|integer|min:1|max:5',
        ]);

        $ulasan = Ulasan::findOrFail($request->id);

        // Cek kepemilikan ulasan
        if ($ulasan->id_pelanggan != auth()->guard('pelanggan')->user()->id_pelanggan) {
            abort(403, 'Tidak diizinkan mengedit ulasan ini.');
        }

        $ulasan->update([
            'comments' => $request->comments,
            'star_rating' => $request->star_rating,
        ]);

        return redirect()->to(url()->previous() . '#ulasan')->with('success', 'Ulasan berhasil diperbarui.');
    }
}
