<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Meja;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function customers()
    {
        $pelanggan = Pelanggan::all();
        return view('admin.customers', compact('pelanggan'));
    }

    public function tables()
    {
        $meja = Meja::all();
        return view('admin.tables', compact('meja'));
    }

    public function updateTable(Request $request)
    {
        try {
            $request->validate([
                'no_meja' => 'required',
                'tipe_meja' => 'required',
                'kapasitas' => 'required|numeric',
                'harga' => 'required|numeric',
                'status' => 'required|in:tersedia,dipesan'
            ]);

            $meja = Meja::where('no_meja', $request->no_meja)->first();
            if (!$meja) {
                return response()->json(['message' => 'Meja tidak ditemukan'], 404);
            }

            $meja->tipe_meja = $request->tipe_meja;
            $meja->kapasitas = $request->kapasitas;
            $meja->harga = $request->harga;
            $meja->status = $request->status;
            $meja->save();

            return response()->json(['message' => 'Data meja berhasil diperbarui']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal: ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateCustomer(Request $request)
    {
        try {
            $request->validate([
                'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
                'email' => 'required|email|unique:pelanggan,email,' . $request->id_pelanggan . ',id_pelanggan',
                'username' => 'required|unique:pelanggan,username,' . $request->id_pelanggan . ',id_pelanggan',
                'nomor_handphone' => 'required|numeric|unique:pelanggan,nomor_handphone,' . $request->id_pelanggan . ',id_pelanggan'
            ]);

            $pelanggan = Pelanggan::find($request->id_pelanggan);
            if (!$pelanggan) {
                return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
            }

            $pelanggan->email = $request->email;
            $pelanggan->username = $request->username;
            $pelanggan->nomor_handphone = $request->nomor_handphone;
            $pelanggan->save();

            return response()->json(['message' => 'Data pelanggan berhasil diperbarui']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal: ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function deleteCustomer(Request $request)
    {
        try {
            $request->validate([
                'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan'
            ]);

            $pelanggan = Pelanggan::find($request->id_pelanggan);
            if (!$pelanggan) {
                return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
            }

            $pelanggan->delete();
            return response()->json(['message' => 'Data pelanggan berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
