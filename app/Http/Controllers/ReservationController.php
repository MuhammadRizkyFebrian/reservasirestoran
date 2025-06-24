<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'no_handphone' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah_tamu' => 'required|integer|min:1',
            'no_meja' => 'required|array',
            'no_meja.*' => 'integer|distinct|min:1',
        ]);

            $kodeTransaksi = 'TRX' . now()->format('YmdHis') . strtoupper(Str::random(3));

        // 2. Simpan ke semua pemesanan (jika pilih banyak meja)
        foreach ($request->no_meja as $mejaId) {
            Pesanan::create([
                'id_pelanggan' => auth('pelanggan')->id(),
                'no_meja' => $mejaId,
                'nama_pemesan' => $request->nama_pemesan,
                'jumlah_tamu' => $request->jumlah_tamu,
                'no_handphone' => $request->no_handphone,
                'catatan' => $request->catatan,
                'jadwal' => $request->tanggal . ' ' . $request->jam,
                'kode_transaksi' => $kodeTransaksi, // <- disimpan ke DB
            ]);
        }

        // 3. Redirect ke halaman pembayaran dengan kode
        return redirect()->route('payment', ['kode' => $kodeTransaksi])
            ->with('success', 'Reservasi berhasil!');
    }

    public function payment($kode)
    {
        $pemesanan = Pesanan::where('kode_transaksi', $kode)
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->get();

        return view('payment', [
            'pemesanan' => $pemesanan,
            'kode' => $kode,
        ]);
    }

}