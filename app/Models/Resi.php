<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resi extends Model
{
    protected $table = 'resi';
    protected $primaryKey = 'id_resi';
    public $timestamps = false;
    public $incrementing = false; // Set false karena kita akan generate sendiri
    protected $keyType = 'string'; // Set tipe primary key sebagai string

    protected $fillable = [
        'id_resi',
        'id_pembayaran'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil nomor urut terakhir dari database
            $lastNumber = DB::table('resi')
                ->whereRaw("id_resi REGEXP '^RCP[0-9]+$'")
                ->orderBy('id_resi', 'desc')
                ->value('id_resi');

            if ($lastNumber) {
                // Jika sudah ada resi sebelumnya, ambil nomor dan tambahkan 1
                $lastNumber = (int) substr($lastNumber, 3);
                $nextNumber = $lastNumber + 1;
            } else {
                // Jika belum ada resi, mulai dari 1
                $nextNumber = 1;
            }

            // Format nomor dengan padding 5 digit
            $model->id_resi = 'RCP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }
}
