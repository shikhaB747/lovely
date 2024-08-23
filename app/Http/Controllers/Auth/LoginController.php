<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\{Auth, Hash};

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function adminLogin(LoginRequest $request)
    {
        // Validate the request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        // Get the validated credentials
        $credentials = $request->only('email', 'password');
    
        // Fetch the user without applying any global scopes
        $user = User::withoutGlobalScopes()->where('email', $credentials['email'])->first();

// dd($user);

        // Check if user exists, the password matches and the user has the admin role
        if ($user && Hash::check($credentials['password'], $user->password) ) {
 
             // Log in the user
            Auth::login($user);
                                
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
    
            // Flash a success message to the session
            session()->flash('success', 'You have successfully logged in as an admin.');
    
            // Redirect to the intended page or the admin dashboard if none set
            return redirect()->intended('admin/dashboard');
        }
   
        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you do not have admin access.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
