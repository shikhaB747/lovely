<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title'];

    protected $hidden   = ['created_at', 'updated_at'];

    public function getSubTitleAttribute($value)
    {
        $all_values = explode(',', $value);
        return $all_values;
    }
}
