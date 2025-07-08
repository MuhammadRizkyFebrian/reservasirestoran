<?php

namespace App\Models\Pelanggan;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan\Pemesanan;
use App\Models\Pelanggan\Resi;
use App\Models\Staf_Restoran\StafRestoran;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'total_harga',
        'metode_pembayaran',
        'status',
        'id_staf',
        'bukti_pembayaran'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function resi()
    {
        return $this->hasOne(Resi::class, 'id_pembayaran', 'id_pembayaran');
    }

    public function staf()
    {
        return $this->belongsTo(StafRestoran::class, 'id_staf', 'id_staf');
    }
}
