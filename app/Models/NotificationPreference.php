<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'new_matches',
        'expiring_matches',
        'new_messages',
        'tips',
        'survey_feedback'
    ];

    protected $hidden   = ['created_at', 'updated_at'];

    public function getNewMatchesAttribute($value)
    {
        $values = explode(',', $value);
        return $values;
    }

    public function getExpiringMatchesAttribute($value)
    {
        $values = explode(',', $value);
        return $values;
    }

    public function getNewMessagesAttribute($value)
    {
        $values = explode(',', $value);
        return $values;
    }

    public function getTipsAttribute($value)
    {
        $values = explode(',', $value);
        return $values;
    }

    public function getSurveyFeedbackAttribute($value)
    {
        $values = explode(',', $value);
        return $values;
    }
}
