<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $fillable = ['user_id', 'partner_id', 'message', 'image', 'chat_room', 'message_type', 'created_at'];

    protected $hidden = ['updated_at'];
    public function getMessageAttribute($value)
    {
        return $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute($value)
    {
        if (!is_null($value)) {
            $startDate = new DateTime(date('Y-m-d H:i:s'));
            $endDate   = new DateTime($value);

            $interval = $startDate->diff($endDate);
            if ($interval->y > 0) {
                $value = $interval->y . " years ago";
            } else if ($interval->m > 0) {
                $value = $interval->m . " months ago";
            } else if ($interval->d > 0) {
                $value = $interval->d . " days ago";
            } else if ($interval->h > 0) {
                $value = $interval->h . " hours ago";
            } else if ($interval->i > 0) {
                $value = $interval->i . " minutes ago";
            } else if ($interval->s > 0) {
                $value = $interval->s . " seconds ago";
            } else {
                $value = 0;
            }
            return $value;
        }
    }

    function getImageAttribute($value)
    {
        if ($value) {
            return asset('uploads/chat_images/' . $value);
        }
        return asset(config('constants.DEFAULT_IMAGE'));
    }

    public function match()
    {
        return Matches::select('id as match_id', 'is_extend', 'expire_at')->where('chat_room', $this->chat_room)->first();
    }
}
