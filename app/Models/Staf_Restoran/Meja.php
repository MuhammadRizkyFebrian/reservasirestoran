<?php

namespace App\Models\Staf_Restoran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Staf_Restoran\StafRestoran;
use App\Models\Pelanggan\Pemesanan;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja';
    protected $primaryKey = 'no_meja';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'no_meja',
        'tipe_meja',
        'kapasitas',
        'id_staf',
        'status',
        'harga'
    ];

    // Relasi dengan model StafRestoran
    public function staf()
    {
        return $this->belongsTo(StafRestoran::class, 'id_staf', 'id_staf');
    }

    // Relasi dengan model Pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'no_meja', 'no_meja');
    }
}
