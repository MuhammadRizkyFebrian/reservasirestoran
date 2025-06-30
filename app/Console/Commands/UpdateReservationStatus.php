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
        $this->info('Waktu sekarang: ' . $now->format('Y-m-d H:i:s'));

        // Ambil semua pesanan dengan status 'dikonfirmasi' yang jadwalnya sudah lewat 1 jam
        $query = Pesanan::where('status', 'dikonfirmasi')
            ->where('jadwal', '<', $now->copy()->subHour());

        $this->info('SQL Query: ' . $query->toSql());
        $this->info('Query Bindings: ' . json_encode($query->getBindings()));

        $pesananSelesai = $query->get();

        if ($pesananSelesai->isEmpty()) {
            $this->info('Tidak ada reservasi yang perlu diupdate.');

            // Tampilkan beberapa data pesanan untuk debugging
            $this->info('Sampling data pesanan yang ada:');
            $samplePesanan = Pesanan::select('id_pemesanan', 'jadwal', 'status')
                ->orderBy('jadwal', 'desc')
                ->limit(5)
                ->get();

            foreach ($samplePesanan as $pesanan) {
                $jadwal = Carbon::parse($pesanan->jadwal);
                $selisihJam = $now->diffInHours($jadwal, false);
                $this->info("ID: {$pesanan->id_pemesanan}, Jadwal: {$pesanan->jadwal}, Status: {$pesanan->status}, Selisih Jam: {$selisihJam}");
            }

            return;
        }

        foreach ($pesananSelesai as $pesanan) {
            $jadwal = Carbon::parse($pesanan->jadwal);
            $selisihJam = $now->diffInHours($jadwal, false);

            $this->info("Memproses pesanan ID: {$pesanan->id_pemesanan}");
            $this->info("Jadwal: {$pesanan->jadwal} (${selisihJam} jam yang lalu)");

            try {
                // Update status pesanan
                $pesanan->update(['status' => 'selesai']);

                // Update status pembayaran
                $updated = Pembayaran::where('id_pemesanan', $pesanan->id_pemesanan)
                    ->where('status', 'dikonfirmasi')
                    ->update(['status' => 'selesai']);

                $this->info("Berhasil update pembayaran: " . ($updated ? "Ya" : "Tidak"));
            } catch (\Exception $e) {
                $this->error("Error pada pesanan {$pesanan->id_pemesanan}: " . $e->getMessage());
                Log::error("Error updating reservation status: " . $e->getMessage());
            }
        }

        $this->info('Berhasil mengupdate ' . $pesananSelesai->count() . ' reservasi menjadi selesai.');
    }
}
