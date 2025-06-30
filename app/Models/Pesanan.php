<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    // Nama tabel di database
    protected $table = 'pemesanan';

    // Primary key (default Laravel pakai 'id', ini kita ubah)
    protected $primaryKey = 'id_pemesanan';

    // Tidak pakai timestamps (created_at, updated_at)
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_pemesanan',
        'id_pelanggan',
        'no_meja',
        'nama_pemesan',
        'jumlah_tamu',
        'no_handphone',
        'catatan',
        'jadwal',
        'kode_transaksi',
        'status',
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }

    // Relasi ke meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'no_meja', 'no_meja');
    }
}
