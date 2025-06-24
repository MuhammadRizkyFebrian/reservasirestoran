<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan'; // Nama tabel di database

    protected $primaryKey = 'id_pemesanan'; 

    public $timestamps = false; // Optional, tergantung tabel kamu ada created_at/updated_at atau tidak

    protected $fillable = [
        'id_pelanggan',
        'no_meja',
        'nama_pemesanan',
        'jumlah_tamu',
        'jadwal',
    ];

    // Relasi ke tabel ulasan
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pemesanan');
    }
}
