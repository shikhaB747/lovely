<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs as MailContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, PasswordReset};
use Illuminate\Support\Facades\{DB as FacadesDB, Mail, Redirect, Validator};

class ForgotPasswordController extends Controller
{

    public function forgot_password()
    {
        return view('auth.forgot-password');
    }

    /**
     * Forgot Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->with('error', 'Please enter correct Email address');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Redirect::back()->with('error', 'User not found!');
        }

        $token = uniqid(base64_encode(Str::random(100)));
        $email = $request->email;

        $checkToken = PasswordReset::where(['email' => $email])->first();

        if (!empty($checkToken)) {
            PasswordReset::where('email', $email)->update(['email' => $email, 'token' => $token, 'created_at' => date('Y-m-d h:i:s')]);
        } else {
            PasswordReset::insert(['email' => $email, 'token' => $token, 'created_at' => date('Y-m-d h:i:s')]);
        }

        User::where('email', $request->email)->update(['remember_token' => $token]);

        try {
            $to = $request->email;
            $mailData['name']     = $user->name;
            $mailData['subject']  = "Password Reset Request";
            $mailData['template'] = 'forget_password';
            $mailData['to']       = $to;
            $mailData['link']     = url('/password/reset/' . $token);

            Mail::to($mailData['to'])->send(new MailContactUs($mailData));
        } catch (\Throwable $th) {
        }

        return back()->with(['message' => 'Mail Send!']);
    }

    /**
     * Set password view page
     * @param int
     */
    public function setPassword($token)
    {
        try {
            $users =  FacadesDB::table('password_resets')->where('token', $token)->first();
            $data  =  User::where('remember_token', $token)->first();

            if ($users && $data) {
                return view('admin/auth/reset-password', compact('users', 'data'));
            } else {
                return Redirect::route('sign-up')->with('error', 'Invalid token');
            }
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reset password
     * @param object
     */
    public function reset_password(Request $request)
    {

        try {
            $token = $request->token;
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                $request->validate([
                    'password'         => 'required|min:8',
                    'confirm_password' => 'required|min:8|same:password',
                ]);

                $data['password'] = Hash::make($request->password);

                $changePassword = $user->update($data);

                if ($changePassword) {
                    return Redirect::route('sign-up')->with('success', 'Password updated successfully');
                } else {
                    return Redirect::back()->with('error', 'Something went wrong');
                }
            } else {
                return Redirect::back()->with('error', 'Something went wrong!');
            }
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    // Admin password reset =========
    public function changePassword(Request $request)
    {

        $email = session('email');
        $user = User::where('email', $email)->first();

        if ($user) {

            $request->validate([
                'old_password'         => 'required',
                'new_password'         => 'required|min:8',
                'confirm_new_password' => 'required|min:8|same:new_password',
            ]);

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with(['error' => 'The old password is incorrect.']);
            }
            $data['password'] = Hash::make($request->new_password);

            $user->update($data);

            return Redirect::back()->with('success', 'Password Updated!');
        }

        return Redirect::back()->with('error', 'Something went wrong!');
    }
}
