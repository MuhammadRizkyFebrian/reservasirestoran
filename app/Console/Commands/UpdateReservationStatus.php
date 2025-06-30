<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateReservationStatus extends Command
{
    protected $signature = 'reservation:update-status';
    protected $description = 'Update status reservasi yang sudah lewat 1 jam dari jadwal menjadi selesai';

    public function handle()
    {
        $now = Carbon::now();
        $this->info('Menjalankan update status reservasi...');

        // Ambil semua pesanan dengan status 'dikonfirmasi' yang jadwalnya sudah lewat 1 jam
        $pesananSelesai = Pesanan::where('status', 'dikonfirmasi')
            ->where('jadwal', '<', $now->copy()->subHour())
            ->get();

        if ($pesananSelesai->isEmpty()) {
            $this->info('Status: Tidak ada reservasi yang perlu diupdate.');

            // Tampilkan ringkasan data pesanan terbaru
            $this->info("\nRingkasan 5 Reservasi Terakhir:");
            $samplePesanan = Pesanan::select('id_pemesanan', 'jadwal', 'status')
                ->orderBy('jadwal', 'desc')
                ->limit(5)
                ->get();

            $headers = ['ID', 'Jadwal', 'Status'];
            $rows = [];

            foreach ($samplePesanan as $pesanan) {
                $rows[] = [
                    $pesanan->id_pemesanan,
                    Carbon::parse($pesanan->jadwal)->format('H:i'),
                    $pesanan->status
                ];
            }

            $this->table($headers, $rows);
            return;
        }

        $berhasil = 0;
        $gagal = 0;

        foreach ($pesananSelesai as $pesanan) {
            try {
                // Update status pesanan
                $pesanan->update(['status' => 'selesai']);

                // Update status pembayaran
                Pembayaran::where('id_pemesanan', $pesanan->id_pemesanan)
                    ->where('status', 'dikonfirmasi')
                    ->update(['status' => 'selesai']);

                $berhasil++;
            } catch (\Exception $e) {
                $gagal++;
                Log::error("Error updating reservation status for ID {$pesanan->id_pemesanan}: " . $e->getMessage());
            }
        }

        $this->info("\nHasil Update:");
        $this->info("✓ Berhasil: {$berhasil} reservasi");
        if ($gagal > 0) {
            $this->error("✗ Gagal: {$gagal} reservasi");
        }
    }
}
