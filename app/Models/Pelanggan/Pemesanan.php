<?php

namespace App\Models\Pelanggan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan\Pelanggan;
use App\Models\Pelanggan\Pembayaran;
use App\Models\Pelanggan\Ulasan;
use App\Models\Staf_Restoran\Meja;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

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
        'status'
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

    // Relasi ke ulasan
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pemesanan');
    }
}
