<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    // Create
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'comments' => 'required|string',
            'star_rating' => 'required|integer|min:1|max:5',
        ]);

        // Simpan ke tabel ulasan
        Ulasan::create([
            'id_pemesanan' => $request->id_pemesanan,
            'id_pelanggan' => $request->id_pelanggan,
            'comments' => $request->comments,
            'star_rating' => $request->star_rating,
            'status' => 'active',
        ]);

        // Ini akan dikembalikan ke fetch() di JS
        return response()->json([
            'message' => 'Ulasan berhasil ditambahkan!',
        ]);
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
            'comments' => 'required|string',
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
