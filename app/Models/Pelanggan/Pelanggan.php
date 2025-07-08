<?php

namespace App\Models\Pelanggan;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'email',
        'nomor_handphone',
        'foto_profil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
