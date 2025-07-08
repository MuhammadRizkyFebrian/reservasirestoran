<?php

namespace App\Http\Controllers\Staf_Restoran;

use App\Http\Controllers\Controller;
use App\Models\Staf_Restoran\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::paginate(10);
        return view('staf.menu', compact('menus'));
    }

    // Simpan menu baru ke database
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string|max:100',
                'tipe' => 'required|in:makanan,minuman',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $gambarPath = $request->file('gambar')->store('menu', 'public');

            $menu = Menu::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'tipe' => $request->tipe,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => basename($gambarPath),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan!',
                'menu' => $menu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_map(function ($errors) {
                    return implode(', ', $errors);
                }, $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan menu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Tampilkan form edit menu
    public function edit(Menu $menu)
    {
        return response()->json($menu);
    }

    // Update menu di database
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tipe' => 'required|in:makanan,minuman',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $data = $request->only(['nama', 'kategori', 'tipe', 'harga', 'deskripsi']);

            if ($request->hasFile('gambar')) {
                if ($menu->gambar && Storage::disk('public')->exists('menu/' . $menu->gambar)) {
                    Storage::disk('public')->delete('menu/' . $menu->gambar);
                }

                $gambarPath = $request->file('gambar')->store('menu', 'public');
                $data['gambar'] = basename($gambarPath);
            }

            $menu->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diupdate!',
                'menu' => $menu
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal update menu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate menu!'
            ], 500);
        }
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        try {
            // Hapus gambar jika ada
            if ($menu->gambar && Storage::disk('public')->exists('menu/' . $menu->gambar)) {
                Storage::disk('public')->delete('menu/' . $menu->gambar);
            }

            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus menu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu!'
            ], 500);
        }
    }

    // Tampilkan menu untuk pelanggan
    public function menuPelanggan()
    {
        $makanan = Menu::where('tipe', 'makanan')->get();
        $minuman = Menu::where('tipe', 'minuman')->get();

        return view('pelanggan.menu', compact('makanan', 'minuman'));
    }
}
