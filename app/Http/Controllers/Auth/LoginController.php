<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Session;

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

    public function logout(Request $request)
    {
            Auth::logout();
    return redirect('/login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email'=>$email, 'password'=>$password, 'is_verified'=>'1'])) {
            // Authentication passed...
            $request->session()->regenerate();
            return redirect()->intended('home');
        }else{
            return redirect()->intended('unverified');
        }
    }

    public function unverify()
    {
        Session::flash('message', 'Wait until your account is verified before you can login.');
            return view('Auth.login'); 
    }

    public function regsuccess()
    {
        Session::flash('message', 'Registration succeeded! Wait until your account is verified before you can login.');
            return view('Auth.login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
