<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_prompt',
        'profile_images',
        'looking_for',
        'relationship_status',
        'like_to_date',
        'about_me',
        'job_role',
        'height',
        'education',
        'do_work_out',
        'do_drink',
        'do_smoke',
        'have_children',
        'zodiac_sign',
        'identify_religion',
        'political_leanings',
        'all_interests',
        'profile_score',
        'language'
    ];

    protected $hidden   = ['created_at', 'updated_at'];

    // Profile image 
    public function getProfileImagesAttribute($value)
    {
        $images[]   =   asset(config('constants.NO_USER_IMG'));
        if ($value) {
            $arrayValues = json_decode($value, true);

            if (is_array($arrayValues)) {
                return array_map(fn($image) => asset('uploads/profile_images/' . $image), $arrayValues);
            }
        }

        return $images;
    }
}
