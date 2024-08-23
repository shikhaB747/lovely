<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'partner_id', 'interaction_type'];

    protected $hidden   = ['created_at', 'updated_at'];
}
