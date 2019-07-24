<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    protected $redirectTo = '/admin';

    public function __construct() {
        $this->middleware('guest:admin')->except(['logout', 'userLogout', 'adminLogout']);
    }

    public function showLoginForm() {
        return view('auth.admin-login');
    }

    public function login(Request $request) {
        
        //dd($request);
        $this->validate($request, [
            'email'=> 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember)) {
            
            return redirect()->intended(route('admin.index'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();

        // $request->session()->invalidate();

        // return $this->loggedOut($request) ?: redirect('/');
        return redirect('/');
    }

    public function guard() {
        return Auth::guard('admin');
    }
}
