<?php

use App\Models\{Interaction as LikesMatch, User};
use Illuminate\Support\Facades\DB as FacadesDB;
use Intervention\Image\Facades\{Image, DB};
use Illuminate\Support\Str;

function fileUpload($file, $dir)
{
    try {
        if (!empty($file)) {
            $fileName = time() . Str::random(4) . "." . $file->getClientOriginalExtension();
            $fullPath = public_path('uploads/' . $dir . '/' . $fileName);

            // Compress image by encoding it as JPG with 75% quality
            $modifiedImage = Image::make($file)->encode('jpg', 75);

            // Ensure the directory exists, if not, create it
            if (!file_exists(public_path('uploads/' . $dir))) {
                mkdir(public_path('uploads/' . $dir), 0777, true);
            }

            // Save the resized and compressed image
            $modifiedImage->save($fullPath);

            return $fileName;
        }
    } catch (\Exception $e) {
        return false;
    }
}

function deleteImage($fileUrl)
{
    // do not remove user's default image
    $noUserImage    =   config('constants.NO_USER_IMG');
    $defaultImg     =   config('constants.DEFAULT_IMAGE');

    if ($fileUrl == asset($noUserImage)) {
        return false;
    }

    if ($fileUrl == asset($defaultImg)) {
        return false;
    }

    $appUrl = config('app.url');

    $relativePath = str_replace($appUrl, '', $fileUrl);

    $localPath = public_path($relativePath);

    if (file_exists($localPath)) {
        unlink($localPath);
        return true;
    } else {
        return false;
    }
}

function updateStatus($table, $field_value, $id)
{
    $status = FacadesDB::statement('Update ' . $table . ' SET ' . $field_value . ' Where id=' . $id);
    return $status;
}

function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Radius of the Earth in kilometers

    $deltaLat = deg2rad($lat2 - $lat1);
    $deltaLon = deg2rad($lon2 - $lon1);

    $a  =  sin($deltaLat / 2) * sin($deltaLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($deltaLon / 2) * sin($deltaLon / 2);

    $c  =  2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c; // Distance in kilometers

    return $distance;
}

function isMatched($userId, $partnerId)
{
    $isMatched = LikesMatch::where(function ($query) use ($userId, $partnerId) {
        $query->where('user_id', $userId)
            ->where('partner_id', $partnerId);
    })->orWhere(function ($query) use ($userId, $partnerId) {
        $query->where('user_id', $partnerId)
            ->where('partner_id', $userId);
    })->exists();

    return $isMatched;
}

function notForMe($userId, $partnerId)
{

    $user          =  User::where('id', $userId)->pluck('not_for_me_ids')->first();

    $notForMeIds   =  explode(',', $user);

    $checkInArray  = in_array($partnerId, $notForMeIds);

    return $checkInArray;
}

function getProfileCompletionScore($id)
{
    $user = User::where('id', $id)->with('userDetails')->first();

    $score = 0;
    $totalWeight = 20;

    $profileData = [
        'birthday' => $user->birthday ?? null,
        'location' =>  $user->location ?? null,
        'profile_prompt' =>  $user->userDetails->profile_prompt ?? null,
        'looking_for' =>  $user->userDetails->looking_for ?? null,
        'relationship_status' =>  $user->userDetails->relationship_status ?? null,
        'like_to_date' =>  $user->userDetails->like_to_date ?? null,
        'about_me' =>  $user->userDetails->about_me ?? null,
        'job_role' =>  $user->userDetails->job_role ?? null,
        'height' =>  $user->userDetails->height ?? null,
        'education' =>  $user->userDetails->education ?? null,
        'do_work_out' =>  $user->userDetails->do_work_out ?? null,
        'do_drink' =>  $user->userDetails->do_drink ?? null,
        'do_smoke' =>  $user->userDetails->do_smoke ?? null,
        'have_children' =>  $user->userDetails->have_children ?? null,
        'zodiac_sign' =>  $user->userDetails->zodiac_sign ?? null,
        'identify_religion' =>  $user->userDetails->identify_religion ?? null,
        'political_leanings' =>  $user->userDetails->political_leanings ?? null,
        'all_interests' =>  $user->userDetails->all_interests ?? null,
        'profile_images' =>  $user->userDetails->profile_images ?? null,
        'language' =>  $user->userDetails->language ?? null,
    ];

    foreach ($profileData as $key => $data) {

        // Check if the field is set and not empty in the profile data
        if (!empty($data)) {
            $score += 1;
        }
    }

    $completionScore = ($score / $totalWeight) * 100;

    return round($completionScore);
}
