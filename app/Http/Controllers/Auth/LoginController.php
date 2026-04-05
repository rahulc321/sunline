<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{User};

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginFormSuper(){
        return view('auth.super_login');
    }

    

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        // fetch user first
        $user = User::where('email', $credentials['email'])->first();
       
        
       
        // attempt login with SUPERADMIN guard
        if (Auth::guard('superadmin')->attempt($credentials)) {
           
            $request->session()->regenerate();
    
            return redirect()->route('superadmin.dashboard');
        }

        // user not found OR not director
        if (!$user || !$user->roles->contains('title', 'Director')) {
            return back()->withErrors([
                'email' => 'Unauthorized access',
            ]);
        }

        
       // dd(1);
    
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

}
