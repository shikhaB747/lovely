<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSupport extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reported_user_id', 'question', 'reason', 'attachment', 'row_type'];

    protected $hidden   = ['created_at', 'updated_at'];
}
