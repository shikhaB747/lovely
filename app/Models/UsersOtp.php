<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOtp extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'otp', 'otp_expires_at'];
}
