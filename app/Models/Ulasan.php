<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan'; // nama tabel di database

    protected $primaryKey = 'id';
    protected $fillable = [
        'id_pemesanan',
        'id_pelanggan',
        'comments',
        'star_rating',
        'status',
    ];

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
 
    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}