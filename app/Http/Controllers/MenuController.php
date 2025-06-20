<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu', compact('menus'));
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

            Menu::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'tipe' => $request->tipe,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => basename($gambarPath),
            ]);

            return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validasi gagal: ' . json_encode($e->errors()));
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', array_map(function ($errors) {
                return implode(', ', $errors);
            }, $e->errors())));
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan menu: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    // Tampilkan form edit menu
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
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

            return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate!');
        } catch (\Exception $e) {
            \Log::error('Gagal update menu: ' . $e->getMessage()); // untuk debugging
            return redirect()->route('menus.index')->with('error', 'Gagal mengupdate menu!');
        }
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->gambar && Storage::disk('public')->exists('menu/' . $menu->gambar)) {
            Storage::disk('public')->delete('menu/' . $menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    // Tampilkan menu untuk pelanggan
    public function menuPelanggan()
    {
        $makanan = Menu::where('tipe', 'makanan')->get();
        $minuman = Menu::where('tipe', 'minuman')->get();

        return view('menu', compact('makanan', 'minuman'));
    }
}
