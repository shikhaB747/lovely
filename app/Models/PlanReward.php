<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'is_premium',
        'super_likes_count',
        'spot_light_count',
        'plan_expiry_date'
    ];


    protected $hidden   = ['created_at', 'updated_at'];
}
