<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        // Add any logic you want to execute when the model is booted
        static::addGlobalScope('active', function ($query) {
            $query->where('status', '!=', '3');
        });
    }

    protected $fillable = [
        'category',
        'title',
        'sub_title',
        'super_likes_count',
        'spot_light_count',
        'price',
        'discount',
        'duration',
        'description',
        'validity'
    ];

    protected $hidden   = ['created_at', 'updated_at'];

    public function membershipPlans()
    {
        return $this->hasMany(MembershipPlan::class, 'category', 'category');
    }
}
