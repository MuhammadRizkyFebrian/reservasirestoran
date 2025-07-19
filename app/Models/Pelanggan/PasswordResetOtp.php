<?php

namespace App\Models\Pelanggan;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $table = 'otp';
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'kode_otp',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
