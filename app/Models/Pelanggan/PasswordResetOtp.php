<?php

namespace App\Models\Pelanggan;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $table = 'password_reset_otps';
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'email',
        'otp',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
