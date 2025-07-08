<?php

namespace App\Http\Controllers\Staf_Restoran;

use App\Http\Controllers\Controller;
use App\Models\Staf_Restoran\StafRestoran;
use App\Models\Staf_Restoran\Meja;
use App\Models\Staf_Restoran\Menu;
use App\Models\Pelanggan\Pelanggan;
use App\Models\Pelanggan\Pemesanan;
use App\Models\Pelanggan\Pembayaran;
use App\Models\Pelanggan\Resi;
use App\Models\Pelanggan\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function customers()
    {
        $pelanggan = Pelanggan::paginate(10);
        return view('staf.customers', compact('pelanggan'));
    }

    public function tables()
    {
        $meja = Meja::paginate(10);
        return view('staf.tables', compact('meja'));
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

    public function pemesanan()
    {
        $pemesanan = Pemesanan::with(['pembayaran'])
            ->select(
                'kode_transaksi',
                DB::raw('GROUP_CONCAT(no_meja) as nomor_meja'),
                'nama_pemesan',
                'jumlah_tamu',
                'no_handphone',
                'jadwal',
                'status',
                DB::raw('MAX(id_pemesanan) as id_pemesanan')
            )
            ->groupBy('kode_transaksi', 'nama_pemesan', 'jumlah_tamu', 'no_handphone', 'jadwal', 'status')
            ->orderBy('id_pemesanan', 'desc')
            ->paginate(10);

        // Ambil data pembayaran untuk setiap kode transaksi
        foreach ($pemesanan as $p) {
            $pembayaran = Pembayaran::whereHas('pemesanan', function ($query) use ($p) {
                $query->where('kode_transaksi', $p->kode_transaksi);
            })->first();

            $p->pembayaran = $pembayaran;
        }

        return view('staf.pemesanan', compact('pemesanan'));
    }

    public function transactions()
    {
        // Ambil semua kode transaksi yang unik
        $uniqueTransactions = Pemesanan::select('kode_transaksi', DB::raw('MAX(id_pemesanan) as latest_id'))
            ->whereIn('status', ['dikonfirmasi', 'selesai'])
            ->groupBy('kode_transaksi')
            ->orderBy('latest_id', 'desc')
            ->paginate(10);

        $transactions = collect();

        foreach ($uniqueTransactions as $trans) {
            // Ambil semua pesanan dengan kode transaksi yang sama
            $pesanan = Pemesanan::where('kode_transaksi', $trans->kode_transaksi)
                ->with('pembayaran')
                ->get();

            if ($pesanan->isNotEmpty()) {
                $firstPesanan = $pesanan->first();

                // Hitung total harga
                $totalHarga = 0;
                foreach ($pesanan as $p) {
                    $meja = Meja::find($p->no_meja);
                    if ($meja) {
                        $totalHarga += $meja->harga;
                    }
                }
                $totalHarga += 3000; // Biaya layanan

                // Gabungkan nomor meja
                $nomorMeja = $pesanan->pluck('no_meja')->join(',');

                // Ambil data pembayaran
                $pembayaran = $firstPesanan->pembayaran;

                // Buat objek transaksi
                $transaction = new \stdClass();
                $transaction->kode_transaksi = $trans->kode_transaksi;
                $transaction->nomor_meja = $nomorMeja;
                $transaction->total_harga = $totalHarga;
                $transaction->id_pembayaran = $pembayaran ? $pembayaran->id_pembayaran : null;
                $transaction->metode_pembayaran = $pembayaran ? $pembayaran->metode_pembayaran : null;
                $transaction->status = $pembayaran ? $pembayaran->status : null;
                $transaction->bukti_pembayaran = $pembayaran ? $pembayaran->bukti_pembayaran : null;
                $transaction->id_pemesanan = $trans->latest_id;

                $transactions->push($transaction);
            }
        }

        // Urutkan collection berdasarkan id pemesanan terbaru
        $transactions = $transactions->sortByDesc('id_pemesanan');

        // Set pagination untuk collection
        $transactions = new \Illuminate\Pagination\LengthAwarePaginator(
            $transactions,
            $uniqueTransactions->total(),
            $uniqueTransactions->perPage(),
            $uniqueTransactions->currentPage(),
            ['path' => request()->url()]
        );

        return view('staf.riwayat-transaksi', compact('transactions'));
    }

    public function dashboard()
    {
        $totalMeja = Meja::count();
        $totalPelanggan = Pelanggan::count();
        $totalMenu = Menu::count();
        $totalReservasi = Pemesanan::count();
        $totalTransaksi = Pemesanan::whereIn('status', ['selesai', 'dikonfirmasi'])
            ->distinct()
            ->count('kode_transaksi');

        return view('staf.dashboard', compact(
            'totalMeja',
            'totalPelanggan',
            'totalMenu',
            'totalReservasi',
            'totalTransaksi'
        ));
    }

    public function createTable(Request $request)
    {
        try {
            $request->validate([
                'no_meja' => 'required|unique:meja,no_meja',
                'tipe_meja' => 'required|in:persegi,bundar,persegi panjang,vip',
                'kapasitas' => 'required|numeric',
                'harga' => 'required|numeric',
                'status' => 'required|in:tersedia,dipesan'
            ], [
                'no_meja.unique' => 'Nomor meja sudah digunakan'
            ]);

            $meja = new Meja();
            $meja->no_meja = $request->no_meja;
            $meja->tipe_meja = $request->tipe_meja;
            $meja->kapasitas = $request->kapasitas;
            $meja->harga = $request->harga;
            $meja->status = $request->status;
            $meja->id_staf = auth('staf')->id();
            $meja->save();

            return response()->json(['message' => 'Meja berhasil ditambahkan']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal: ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function deleteTable(Request $request)
    {
        try {
            $request->validate([
                'no_meja' => 'required|exists:meja,no_meja'
            ]);

            $meja = Meja::find($request->no_meja);
            if (!$meja) {
                return response()->json(['message' => 'Meja tidak ditemukan'], 404);
            }

            $meja->delete();
            return response()->json(['message' => 'Meja berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function transactionDetail($id)
    {
        try {
            $transaction = Pembayaran::with(['pemesanan.pelanggan'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id_pembayaran' => $transaction->id_pembayaran,
                    'kode_transaksi' => $transaction->pemesanan->kode_transaksi,
                    'nama_pemesan' => $transaction->pemesanan->pelanggan->username ?? 'N/A',
                    'total_harga' => $transaction->total_harga,
                    'metode_pembayaran' => $transaction->metode_pembayaran,
                    'status' => $transaction->status,
                    'bukti_pembayaran' => $transaction->bukti_pembayaran,
                    'created_at' => $transaction->created_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirmTransaction($id)
    {
        try {
            $transaction = Pembayaran::with('pemesanan')
                ->findOrFail($id);

            // Update status pembayaran
            $transaction->update(['status' => 'dikonfirmasi']);

            // Update status pemesanan
            $transaction->pemesanan->update(['status' => 'dikonfirmasi']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengkonfirmasi pembayaran'
            ], 500);
        }
    }

    public function updateTransaction(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
                'total_harga' => 'required|numeric',
                'metode_pembayaran' => 'required|in:bca,bni,bri,mandiri'
            ]);

            $transaction = Pembayaran::with('pemesanan')
                ->findOrFail($id);

            // Update pembayaran
            $transaction->update([
                'status' => $request->status,
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // Update status pemesanan jika status pembayaran berubah
            if ($transaction->pemesanan) {
                $transaction->pemesanan->update(['status' => $request->status]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteTransaction($id)
    {
        try {
            $transaction = Pembayaran::findOrFail($id);

            // Hapus file bukti pembayaran jika ada
            if ($transaction->bukti_pembayaran) {
                $path = storage_path('app/public/bukti_pembayaran/' . $transaction->bukti_pembayaran);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pemesananDetail($kode)
    {
        try {
            // Ambil semua pemesanan dengan kode transaksi yang sama
            $pemesanan = Pemesanan::with(['pembayaran'])
                ->where('kode_transaksi', $kode)
                ->get();

            if ($pemesanan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pemesanan tidak ditemukan'
                ], 404);
            }

            // Ambil data pemesanan pertama untuk informasi umum
            $firstPemesanan = $pemesanan->first();

            // Hitung total harga dari semua meja
            $totalHargaMeja = 0;
            $nomorMeja = [];

            foreach ($pemesanan as $p) {
                // Ambil harga meja dari tabel meja
                $meja = Meja::where('no_meja', $p->no_meja)->first();
                if ($meja) {
                    $totalHargaMeja += $meja->harga;
                }
                $nomorMeja[] = $p->no_meja;
            }

            // Biaya layanan tetap Rp3.000 untuk satu reservasi
            $biayaLayanan = 3000;
            $totalPembayaran = $totalHargaMeja + $biayaLayanan;

            $data = [
                'kode_transaksi' => $kode,
                'nama_pemesan' => $firstPemesanan->nama_pemesan,
                'nomor_meja' => implode(',', $nomorMeja),
                'no_handphone' => $firstPemesanan->no_handphone,
                'jumlah_tamu' => $firstPemesanan->jumlah_tamu,
                'jadwal' => \Carbon\Carbon::parse($firstPemesanan->jadwal)->format('d M Y H:i'),
                'status_pemesanan' => ucfirst($firstPemesanan->status),
                'status_pembayaran' => 'Menunggu',
                'total_pembayaran' => $totalPembayaran,
                'bukti_pembayaran' => null
            ];

            if ($firstPemesanan->pembayaran) {
                $data['status_pembayaran'] = ucfirst($firstPemesanan->pembayaran->status);
                $data['bukti_pembayaran'] = $firstPemesanan->pembayaran->bukti_pembayaran;
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function konfirmasiPemesanan($kode)
    {
        try {
            $pemesanan = Pemesanan::where('kode_transaksi', $kode)->get();

            if ($pemesanan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pemesanan tidak ditemukan'
                ], 404);
            }

            foreach ($pemesanan as $p) {
                // Update status pemesanan
                $p->status = 'dikonfirmasi';
                $p->save();

                // Update status pembayaran jika ada
                if ($p->pembayaran) {
                    $p->pembayaran->status = 'dikonfirmasi';
                    $p->pembayaran->save();

                    // Buat resi untuk pembayaran yang dikonfirmasi
                    Resi::create([
                        'id_pembayaran' => $p->pembayaran->id_pembayaran
                    ]);
                }

                // Update status meja menjadi dipesan
                $meja = Meja::where('no_meja', $p->no_meja)->first();
                if ($meja) {
                    $meja->status = 'dipesan';
                    $meja->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pemesanan berhasil dikonfirmasi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function batalkanPemesanan($kode)
    {
        try {
            $pemesanan = Pemesanan::where('kode_transaksi', $kode)->get();

            if ($pemesanan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pemesanan tidak ditemukan'
                ], 404);
            }

            foreach ($pemesanan as $p) {
                $p->status = 'dibatalkan';
                $p->save();

                // Update status meja menjadi tersedia
                $meja = Meja::where('no_meja', $p->no_meja)->first();
                if ($meja) {
                    $meja->status = 'tersedia';
                    $meja->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pemesanan berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTableSchedule($no_meja)
    {
        try {
            $now = Carbon::now();

            // Cek apakah ada jadwal untuk meja ini
            $jadwal = Pemesanan::where('no_meja', $no_meja)
                ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                ->where(function ($query) use ($now) {
                    $query->where('jadwal', '>=', $now)
                        ->orWhere(function ($q) use ($now) {
                            // Tampilkan jadwal yang belum lewat 1 jam
                            $q->where('jadwal', '<', $now)
                                ->where('jadwal', '>=', $now->copy()->subHour());
                        });
                })
                ->select('kode_transaksi', 'nama_pemesan', 'jadwal', 'status')
                ->orderBy('jadwal', 'asc')
                ->get()
                ->map(function ($pesanan) {
                    return [
                        'kode_transaksi' => $pesanan->kode_transaksi,
                        'nama_pemesan' => $pesanan->nama_pemesan,
                        'tanggal' => Carbon::parse($pesanan->jadwal)->translatedFormat('d M Y'),
                        'waktu' => Carbon::parse($pesanan->jadwal)->format('H:i'),
                        'status' => $pesanan->status
                    ];
                });

            // Update status meja menjadi tersedia jika tidak ada jadwal aktif
            if ($jadwal->isEmpty()) {
                $meja = Meja::find($no_meja);
                if ($meja) {
                    $meja->status = 'tersedia';
                    $meja->save();
                }
            }

            return response()->json([
                'success' => true,
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
