<?php

namespace App\Models\Staf_Restoran;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StafRestoran extends Authenticatable
{
    use Notifiable;

    protected $table = 'staf_restoran';
    protected $primaryKey = 'id_staf';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
