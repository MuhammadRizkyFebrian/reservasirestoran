<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Meja;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pemesan' => 'required',
                'no_handphone' => 'required',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'jumlah_tamu' => 'required|integer|min:1',
                'no_meja' => 'required|array',
                'no_meja.*' => 'integer|distinct|min:1',
            ]);

            // Validasi waktu pemesanan minimal 10 menit sebelum jadwal
            $jadwalPemesanan = Carbon::parse($request->tanggal . ' ' . $request->jam);
            $waktuSekarang = Carbon::now();
            $selisihMenit = $waktuSekarang->diffInMinutes($jadwalPemesanan, false);

            if ($selisihMenit < 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemesanan harus dilakukan minimal 10 menit sebelum jadwal yang dipilih.'
                ], 422);
            }

            $kodeTransaksi = 'TRX' . now()->format('YmdHis') . strtoupper(Str::random(3));

            foreach ($request->no_meja as $mejaId) {
                Pesanan::create([
                    'id_pelanggan' => auth('pelanggan')->id(),
                    'no_meja' => $mejaId,
                    'nama_pemesan' => $request->nama_pemesan,
                    'jumlah_tamu' => $request->jumlah_tamu,
                    'no_handphone' => $request->no_handphone,
                    'catatan' => $request->catatan,
                    'jadwal' => $jadwalPemesanan,
                    'kode_transaksi' => $kodeTransaksi,
                    'status' => 'menunggu',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil!',
                'redirect' => route('payment', ['kode' => $kodeTransaksi])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payment($kode)
    {
        $pemesanan = Pesanan::with('meja')
            ->where('kode_transaksi', $kode)
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->get();

        return view('payment', compact('pemesanan', 'kode'));
    }

    public function confirmPayment(Request $request)
    {
        try {
            $request->validate([
                'bank' => 'required|in:bca,bni,bri,mandiri',
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kode_transaksi' => 'required|string',
                'total_harga' => 'required|numeric'
            ], [
                'bank.required' => 'Bank pengirim harus dipilih',
                'bank.in' => 'Bank yang dipilih tidak valid',
                'bukti_pembayaran.required' => 'Bukti pembayaran harus diunggah',
                'bukti_pembayaran.image' => 'File harus berupa gambar',
                'bukti_pembayaran.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            // Upload bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Ambil id_pemesanan dari kode transaksi
            $pemesanan = Pesanan::where('kode_transaksi', $request->kode_transaksi)
                ->where('id_pelanggan', auth('pelanggan')->id())
                ->first();

            if (!$pemesanan) {
                throw new \Exception('Data pemesanan tidak ditemukan');
            }

            // Simpan data pembayaran
            $pembayaran = \App\Models\Pembayaran::create([
                'id_pemesanan' => $pemesanan->id_pemesanan,
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->bank,
                'status' => 'menunggu',
                'bukti_pembayaran' => basename($buktiPath),
                'id_staf' => null
            ]);

            // Update status pemesanan menjadi menunggu
            $pemesanan->update(['status' => 'menunggu']);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil dikirim'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelReservation($kode)
    {
        try {
            // Ambil semua pesanan dengan kode transaksi yang sama
            $pesanan = Pesanan::where('kode_transaksi', $kode)
                ->where('id_pelanggan', auth('pelanggan')->id())
                ->get();

            if ($pesanan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pemesanan tidak ditemukan'
                ], 404);
            }

            // Cek apakah ada pesanan yang sudah dikonfirmasi
            $adaPesananDikonfirmasi = $pesanan->contains(function ($p) {
                return $p->status === 'dikonfirmasi' || $p->status === 'selesai';
            });

            if ($adaPesananDikonfirmasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membatalkan pesanan yang sudah dikonfirmasi atau selesai'
                ], 400);
            }

            // Update status semua pesanan menjadi dibatalkan
            foreach ($pesanan as $p) {
                $p->update(['status' => 'dibatalkan']);

                // Update status pembayaran jika ada
                \App\Models\Pembayaran::where('id_pemesanan', $p->id_pemesanan)
                    ->update(['status' => 'dibatalkan']);

                // Kembalikan status meja menjadi tersedia
                \App\Models\Meja::where('no_meja', $p->no_meja)
                    ->update(['status' => 'tersedia']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat membatalkan reservasi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        $reservasi = Pesanan::where('id_pelanggan', auth('pelanggan')->id())
            ->select(
                'kode_transaksi',
                DB::raw('GROUP_CONCAT(no_meja) as meja_list'),
                DB::raw('MAX(nama_pemesan) as nama_pemesan'),
                DB::raw('MAX(jumlah_tamu) as jumlah_tamu'),
                DB::raw('MAX(no_handphone) as no_handphone'),
                DB::raw('MAX(catatan) as catatan'),
                DB::raw('MAX(jadwal) as jadwal'),
                DB::raw('MAX(status) as status'),
                DB::raw('COUNT(no_meja) as jumlah_meja')
            )
            ->groupBy('kode_transaksi')
            ->orderBy('kode_transaksi', 'desc')
            ->get();

        return view('reservation-history', compact('reservasi'));
    }

    public function getReceiptDetail($kode)
    {
        try {
            $pesanan = Pesanan::where('kode_transaksi', $kode)
                ->where('id_pelanggan', auth('pelanggan')->id())
                ->first();

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pesanan tidak ditemukan'
                ], 404);
            }

            if (!$pesanan->pembayaran || !$pesanan->pembayaran->resi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resi belum tersedia'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'id_resi' => $pesanan->pembayaran->resi->id_resi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getReservationDetail($kode)
    {
        try {
            // Ambil semua pemesanan dengan kode transaksi yang sama
            $pemesanan = Pesanan::with(['pembayaran'])
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

            $tanggal = \Carbon\Carbon::parse($firstPemesanan->jadwal)->translatedFormat('d M Y');
            $jam = \Carbon\Carbon::parse($firstPemesanan->jadwal)->format('H:i');

            $data = [
                'kode_transaksi' => $kode,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'meja_list' => implode(', ', $nomorMeja),
                'jumlah_tamu' => $firstPemesanan->jumlah_tamu,
                'status_pemesanan' => $firstPemesanan->status,
                'harga_meja' => $totalHargaMeja,
                'biaya_layanan' => $biayaLayanan,
                'total_harga' => $totalPembayaran
            ];

            // Tambahkan informasi pembayaran jika ada
            if ($firstPemesanan->pembayaran) {
                $data['status_pembayaran'] = $firstPemesanan->pembayaran->status;
                $data['metode_pembayaran'] = $firstPemesanan->pembayaran->metode_pembayaran;
                $data['bukti_pembayaran'] = $firstPemesanan->pembayaran->bukti_pembayaran;
            } else {
                $data['status_pembayaran'] = 'menunggu';
                $data['metode_pembayaran'] = null;
                $data['bukti_pembayaran'] = null;
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

    public function uploadPaymentProof(Request $request)
    {
        try {
            Log::info('Memulai proses upload bukti pembayaran', [
                'kode_transaksi' => $request->kode_transaksi
            ]);

            $request->validate([
                'kode_transaksi' => 'required|string',
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'metode_pembayaran' => 'required|in:bca,bni,bri,mandiri'
            ]);

            // Cari semua pesanan dengan kode transaksi yang sama
            $pesanan = Pesanan::where('kode_transaksi', $request->kode_transaksi)
                ->where('id_pelanggan', auth('pelanggan')->id())
                ->get();

            if ($pesanan->isEmpty()) {
                Log::warning('Pesanan tidak ditemukan', [
                    'kode_transaksi' => $request->kode_transaksi,
                    'id_pelanggan' => auth('pelanggan')->id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi tidak ditemukan'
                ], 404);
            }

            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');

                // Generate nama file yang unik
                $filename = time() . '_' . $request->kode_transaksi . '.' . $file->getClientOriginalExtension();

                // Upload file ke storage/app/public/bukti_pembayaran
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

                if (!$path) {
                    Log::error('Gagal menyimpan file', [
                        'filename' => $filename
                    ]);
                    throw new \Exception('Gagal menyimpan file bukti pembayaran');
                }

                Log::info('File berhasil diupload', [
                    'path' => $path,
                    'filename' => $filename
                ]);

                DB::beginTransaction();
                try {
                    // Hitung total harga berdasarkan jumlah meja
                    $jumlah_meja = $pesanan->count();
                    $harga_per_meja = 40000; // 25000 + 15000
                    $total_harga = $harga_per_meja * $jumlah_meja;

                    // Update semua pesanan dengan kode transaksi yang sama
                    foreach ($pesanan as $p) {
                        // Hapus file lama jika ada
                        if ($p->bukti_pembayaran) {
                            Storage::disk('public')->delete('bukti_pembayaran/' . $p->bukti_pembayaran);
                        }

                        $p->update([
                            'bukti_pembayaran' => $filename,
                            'status' => 'menunggu'
                        ]);

                        // Buat atau update data pembayaran
                        \App\Models\Pembayaran::updateOrCreate(
                            ['id_pemesanan' => $p->id_pemesanan],
                            [
                                'total_harga' => $total_harga,
                                'metode_pembayaran' => $request->metode_pembayaran,
                                'status' => 'menunggu',
                                'bukti_pembayaran' => $filename,
                                'id_staf' => null,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );
                    }

                    DB::commit();
                    Log::info('Bukti pembayaran dan data pembayaran berhasil disimpan', [
                        'kode_transaksi' => $request->kode_transaksi,
                        'metode_pembayaran' => $request->metode_pembayaran
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Bukti pembayaran berhasil diupload'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error('Error saat menyimpan data pembayaran', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw new \Exception('Gagal menyimpan data pembayaran: ' . $e->getMessage());
                }
            }

            Log::warning('File bukti pembayaran tidak ditemukan dalam request');
            return response()->json([
                'success' => false,
                'message' => 'File bukti pembayaran tidak ditemukan'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal', [
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_map(function ($err) {
                    return $err[0];
                }, $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saat upload bukti pembayaran', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupload bukti pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showReceipt($kode)
    {
        try {
            $pesanan = Pesanan::with(['meja', 'pembayaran'])
                ->where('kode_transaksi', $kode)
                ->where('id_pelanggan', auth('pelanggan')->id())
                ->first();

            if (!$pesanan) {
                return redirect()->route('reservation-history')
                    ->with('error', 'Data pesanan tidak ditemukan');
            }

            // Hitung total harga
            $biaya_layanan = 3000;
            $harga_meja = $pesanan->meja ? $pesanan->meja->harga : 0;
            $total = $harga_meja + $biaya_layanan;

            // Format tanggal dan waktu
            $tanggal = \Carbon\Carbon::parse($pesanan->jadwal)->translatedFormat('d M Y');
            $waktu = \Carbon\Carbon::parse($pesanan->jadwal)->format('H:i');

            $data = [
                'kode_transaksi' => $pesanan->kode_transaksi,
                'nama_pemesan' => $pesanan->nama_pemesan,
                'no_handphone' => $pesanan->no_handphone,
                'nomor_meja' => 'Meja ' . $pesanan->no_meja,
                'jumlah_tamu' => $pesanan->jumlah_tamu,
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'status' => ucfirst($pesanan->status),
                'catatan' => $pesanan->catatan,
                'harga_meja' => $harga_meja,
                'biaya_layanan' => $biaya_layanan,
                'total' => $total,
                'status_pembayaran' => $pesanan->pembayaran ? ucfirst($pesanan->pembayaran->status) : 'Belum Bayar'
            ];

            return view('reservation-receipt', $data);
        } catch (\Exception $e) {
            return redirect()->route('reservation-history')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkTableAvailability(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i'
            ]);

            $datetime = $request->date . ' ' . $request->time;
            $endDatetime = Carbon::parse($datetime)->addHour();

            // Cek meja yang sudah dipesan pada waktu tersebut
            $bookedTables = Pesanan::where(function ($query) use ($datetime, $endDatetime) {
                $query->where(function ($q) use ($datetime, $endDatetime) {
                    // Cek apakah ada pesanan yang jadwalnya bertabrakan
                    $q->where('jadwal', '<=', $datetime)
                        ->where(DB::raw('DATE_ADD(jadwal, INTERVAL 1 HOUR)'), '>', $datetime);
                })
                    ->orWhere(function ($q) use ($datetime, $endDatetime) {
                        $q->where('jadwal', '<', $endDatetime)
                            ->where('jadwal', '>=', $datetime);
                    });
            })
                ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                ->pluck('no_meja')
                ->toArray();

            // Ambil semua meja dan set status berdasarkan ketersediaan
            $tables = Meja::all()->map(function ($table) use ($bookedTables) {
                $table->status = in_array($table->no_meja, $bookedTables) ? 'dipesan' : 'tersedia';
                return $table;
            });

            return response()->json([
                'success' => true,
                'tables' => $tables
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
