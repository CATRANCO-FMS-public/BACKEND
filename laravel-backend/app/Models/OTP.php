<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $table = 'otps';

    protected $primaryKey = 'id';

    protected $fillable = [
        'phone_number',
        'otp',
        'is_verified',
        'expires_at',
    ];

    protected $dates = ['expires_at'];
}
