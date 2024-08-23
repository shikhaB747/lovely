<?php

namespace App\Http\Controllers\API;

use App\Events\UserSignedUp;
use App\Http\Controllers\Controller;
use App\Models\{Interaction as LikesMatch, User, UserDetail, UsersOtp};
use Illuminate\Support\Facades\{Auth, DB, Validator};
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

class AuthController extends Controller
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    // 
    function verifyUser(Request $request)
    {
       // try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $phone    =  $request->phone;
            $otp      =  $request->otp;

            // checked if account is blocked
            if (!is_null($phone)) {
                $checkUser = User::where('phone', $phone)->first();

                $request['already_user'] = false;

                if (!empty($checkUser)) {

                    $request['already_user'] = true;
                    if ($checkUser->status == '1') {
                        return response()->json(['status' => false, 'message' => 'Your account has been blocked by the administrator!', 'data' => null], 401);
                    }
                }
            }

            if (!is_null($phone) && is_null($otp)) {

                $otp = rand(9999, 999);

                UsersOtp::updateOrCreate(['phone' => $phone], ['otp' => $otp, 'otp_expires_at' => now()->addMinutes(15)]);

                return response()->json(['status' => true, 'message' => 'OTP sent to your registered number', 'data' => ['otp' => $otp, 'otp_sent' => true, 'page' => 'otp_screen']], 200);

            } elseif (!is_null($phone) && !is_null($otp)) {

                
                $usersOtp = UsersOtp::where('phone', $phone)->where('otp', $otp)->first();
                
                if (!$usersOtp) {
                    return response()->json(['status' => false, 'message' => 'Invalid OTP'], 401);
                }
                
                UsersOtp::where('phone', $phone)->update(['otp' => '']);
                
                $checkUser = User::where('phone', $phone)->with('userDetails')->first();
                
                if (!$checkUser) {

                    $checkUser = User::create(['phone' => $phone, 'page' => 'Are_you_looking_for', 'device_token' => $request->device_token]);
                    UserDetail::create(['user_id' => $checkUser->id]);

                }
                
                $user_id  = User::where('phone', $phone)->pluck('id');
                User::where('id', $user_id)->update(['device_token' => $request->device_token]);

                $token     = $checkUser->createToken('phone')->plainTextToken;


                return response()->json(['status' => true, 'message' => 'OTP verified successfully!', 'data' => ['token' => $token, 'already_user' => $request['already_user'], 'user_details' => $checkUser]], 200);
            }

      /* } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }*/
    }

    function calculateAge($birthDate)
    {
        // Create a DateTime object for the birthDate
        $birthDate = new DateTime($birthDate);

        // Create a DateTime object for the current date
        $today = new DateTime('today');

        // Calculate the difference between the two dates
        $age = $birthDate->diff($today)->y;

        // Return the age in years
        return $age;
    }

    /**
     * Profile Details update api
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user  =  $this->loggedInUser;

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'  =>  'string|max:50',
            'email' =>  'email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Assuming these are the columns that belong to the users table
        $userData = $request->only(['name', 'email', 'birthday', 'location', 'gender', 'latitude', 'longitude', 'page', 'incognito_mode', 'travel_mode', 'snooze_hour', 'snooze_from', 'snooze_till', 'device_token']);

        // Assuming these are the columns that belong to the user_details table
        $userDetailData = $request->only([
            'profile_prompt',
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
        ]);

        $profileScore     =  getProfileCompletionScore($user->id);

        $birthDate        =  '';

        if ($request->birthday != '') {
            $birthDate    =  $request->birthday;
        } else {
            $birthDate    =  $user->birthday;
        }

        if (!empty($birthDate)) {
            // Create a DateTime object for the birthDate
            $birthDate    = new DateTime($birthDate);

            // Create a DateTime object for the current date
            $today        = new DateTime('today');

            // Calculate the difference between the two dates
            $age          = $birthDate->diff($today)->y;

            $userData['age'] = $age;
        }

        if ($request->snooze_hour > 1) {
            $userData['snooze_from'] = Carbon::now();
            $userData['snooze_till'] = Carbon::parse(now())->addHours($request->snooze_hour);
        }

        $userDetailData['profile_score'] = $profileScore;
        // Update the User record
        User::where('id', $user->id)->update($userData);

        // Update or create the UserDetail record
        UserDetail::updateOrCreate(
            ['user_id' => $user->id], // The condition to find the existing record
            array_merge(['user_id' => $user->id], $userDetailData) // The attributes to update or create
        );

        $userDetails = User::where('id', $user->id)->with('userDetails')->first();

        // Dispatch the event
        event(new UserSignedUp($user));
        // ===================

        return response()->json(['status' => true, 'message' => 'User profile updated successfully', 'data' => $userDetails], 200);
    }

    /**
     * Profile Details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile(Request $request)
    {

        $user = Auth::user();

        $user_id = $request->user_id;

        if (empty($user_id)) {
            $user_id = $user->id;
        }

        $data = User::where('id', $user_id)->with('userDetails')->first();

        $data->profile_score  =  getProfileCompletionScore($user_id);

        $data->is_friend      =  LikesMatch::where(['user_id' => $this->loggedInUser->id, 'partner_id' => $user_id])->exists();

        // check match

        $loggedUserId         =  Auth::id(); // or $loggedInUserId = $request->user()->id;

        $data->is_match       =  isMatched($loggedUserId, $user_id); // $isMatched;

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Account not found!'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Get user profile successfully', 'data' => $data], 200);
    }

    /**
     * Profile Details api
     *
     * @return \Illuminate\Http\Response
     */
    function updateUserImages(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'images_profile0'  =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $getRequestCount = count($request->all());

        $userDetailData  = [];

        $user_id    =  $this->loggedInUser->id;
        $user_data  =  UserDetail::where('user_id', $user_id)->first();

        // upload user images =======

        $profile_images  =  $oldFilesArray  =  [];

        for ($i = 0; $i < ($getRequestCount - 1); $i++) {

            $image_profile    = $request->file('images_profile' . $i);

            $profile_images[] = fileUpload($image_profile, 'profile_images');

            // image upload by using helper ===
        }

        $oldFilesArray   =  json_decode($user_data->getAttributes()['profile_images']) ?? [];

        $allImagesArray  =  array_merge($oldFilesArray, $profile_images);

        $userDetailData['profile_images'] = json_encode($allImagesArray);

        if (!empty($request->page)) $userData['page'] = $request->page;

        if (sizeof($userDetailData) > 0) {

            $userData['image_profile'] = $allImagesArray[0];
            $userData['social_image']  = 0;

            User::where(['id' => $user_id])->update($userData);
            // Update or create the UserDetail record
            UserDetail::where(['user_id' => $user_id])->update($userDetailData); // The attributes to update or create

            return response()->json(['status' => true, 'message' => 'User images updated successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'User images not uploaded'], 200);
        }
    }

    /** Image update or create */
    function imageUpdateByIndex(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'index'                => 'required|integer',
            'update_image'         => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => $validation->errors()->first()]);
        }

        $user_id          =  $this->loggedInUser->id;

        $user_data        =  DB::table('user_details')->where('user_id', $user_id)->first('profile_images');

        $index            =  $request->index;

        $image_profile    =  $request->file('update_image');

        $imagesFilesArray =  json_decode($user_data->profile_images) ?? [];

        $uploadFile       =  fileUpload($image_profile, 'profile_images');  // upload image

        // ===== update single image of user in user table

        if ($index == 1) {
            $userData['image_profile']  =  $uploadFile;
            $userData['social_image']   =  0;
            User::where('id', $user_id)->update($userData);
        }

        // ===============================================

        if (sizeof($imagesFilesArray) <= $index) {

            // add new image

            $upload_File[]   =  $uploadFile;

            $allImagesArray  =  array_merge($imagesFilesArray, $upload_File);

            $userDetailData['profile_images'] = json_encode($allImagesArray);

            UserDetail::where(['user_id' => $user_id])->update($userDetailData); // The attributes to update or create

            return response()->json(['status' => true, 'message' => 'Image added successfully'], 200);
        }

        $oldIMgName       =  $imagesFilesArray[$index];

        // Replace all values that match a certain condition 
        foreach ($imagesFilesArray as $index => $value) {

            if ($value == $oldIMgName) {
                $imagesFilesArray[$index] = $uploadFile;
            }
        }

        deleteImage(public_path($oldIMgName));  // delete image

        UserDetail::where('user_id', $user_id)->update(['profile_images' => $imagesFilesArray]);

        return response()->json(['status' => true, 'message' => 'Image updated successfully'], 200);
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $email = $request->email;

        // Check if the user exists
        $user  = User::where(['email' => $email])->first();

        try {

            if ($user) {

                if ($user->status == '1') {
                    return response()->json(['status' => false, 'message' => 'Your account has been blocked by the administrator!', 'data' => null], 401);
                } else {

                    $checkUser = User::where('email', $email)->with('userDetails')->first();

                    $token = $checkUser->createToken('device_token')->plainTextToken;

                    User::where('email', $email)->update([
                        'social_id'      => $request->social_id,
                        'social_id_type' => $request->social_id_type,
                        'device_token'   => $request->device_token,
                    ]);

                    $user  =  User::where(['email' => $email])->first();

                    return response()->json(['status' => true, 'message' => 'Login successfully!', 'data' => ['token' => $token, 'already_user' => true, 'user_details' => $user]], 200);
                }

            } else {

                $validator = Validator::make($request->all(), [
                    'email' =>  'email|required|unique:users',
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
                }

                // ========= Update User image ===========

                // User doesn't exist, create a new user
                $user = User::create([
                    'email'          => $email,
                    'name'           => $request->name,
                    'social_id'      => $request->social_id,
                    'social_id_type' => $request->social_id_type,
                    'page'           => 'Are_you_looking_for',
                    'device_token'   => $request->device_token,
                    'image_profile'  => $request->image_profile,
                    'social_image'   => 1,
                ]);

                $token    =    $user->createToken('email')->plainTextToken;

                // ====== Create user details as well ======
                UserDetail::create(['user_id' => $user->id]);

                $checkUser = User::where('email', $email)->first();

                return response()->json(['status' => true, 'message' => 'Registered successfully!', 'data' => ['token' => $token, 'already_user' => false, 'user_details' => $checkUser]], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
