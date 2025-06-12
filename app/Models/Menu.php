<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; 

    protected $primaryKey = 'id_menu'; 

    public $incrementing = true; 
    protected $keyType = 'int';  

    protected $fillable = [
        'nama',
        'gambar',
        'kategori',
        'tipe',
        'deskripsi',
        'harga',
    ];
}
