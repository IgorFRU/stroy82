<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'userLogout', 'adminLogout']);
    }

    protected function credentials(Request $request) {
        if(is_numeric($request->email)){
            $phone = str_replace(array('+','-', '(', ')', ' '), '', $request->email);
            if (strlen($phone) == 11) {
                $phone = substr($phone, 1);
            }
            return ['phone'=>$phone,'password'=>$request->password];
        }
        else {
            return ['email' => $request->email, 'password'=>$request->password];
        }
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // return $this->loggedOut($request) ?: redirect('/');
        return redirect('/');
    }
}
