<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Scopes\SkipIdScope;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected static function boot()
    {
        parent::boot();

        // Apply the global scope to skip ID 1
        static::addGlobalScope(new SkipIdScope());
    }

    /**
     * Fetch data for a specific ID.
     * If the ID is 1, override the global scope.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function findOrFetch($id)
    {
        if ($id == 1) {
            return static::withoutGlobalScope(SkipIdScope::class)->find($id);
        }
        return static::find($id);
    }

    /**
     * Override the default all() method to skip ID 1.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = ['*'])
    {
        return static::withoutGlobalScope(SkipIdScope::class)->where('id', '!=', 1)->get($columns);
    }

    // ======================================================

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'gender',
        'location',
        'latitude',
        'longitude',
        'image_profile',
        'is_premium',
        'premium_expiry_date',
        'total_likes',
        'total_super_likes_points',
        'page',
        'status',
        'device_token',
        'device_type',
        'user_verified',
        'incognito_mode',
        'snooze_hour',
        'snooze_from',
        'snooze_till',
        'travel_mode',
        'age',
        'social_id',
        'social_id_type',
        'social_image',
        'not_for_me_ids',
        'available_spotlight',
        'available_super_likes'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'not_for_me_ids',
        'blocked_ids',
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function scopeActive($query)
    {
        $query->where('status', '0');
    }

    public function getNameAttribute($value)
    {
        return ($value) ? ucfirst($value) : '';
    }

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function scopeNearby($query, $latitude, $longitude, $distance = 500)
    {
        $haversine = "(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))))";

        return $query->select('id', 'latitude', 'longitude')
            ->whereRaw("{$haversine} < ?", [$distance])
            ->where("role", "2");
    }

    function getImageProfileAttribute($value)
    {
        if ($this->social_image == 1) {
            return $value;
        }

        if ($value) {
            return asset('uploads/profile_images/' . $value);
        }
        return asset(config('constants.NO_USER_IMG'));
    }

    public function messageTo()
    {
        return $this->hasMany(Chat::class, 'partner_id');
    }

    public function messageFrom()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class, 'partner_id', 'id');
    }
}
