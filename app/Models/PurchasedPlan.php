<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedPlan extends Model
{
    use HasFactory;

    protected $fillable  =  [
        'user_id',
        'membership_id',
        'purchase_date',
        'start_date',
        'end_date',
        'price',
        'status',
        'txn_id'
    ];

    protected $hidden    =  ['created_at', 'updated_at'];

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
