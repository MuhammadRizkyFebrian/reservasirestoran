<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StafRestoran;

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
}
