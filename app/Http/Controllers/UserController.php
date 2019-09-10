<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        return view('home');
        // echo ('consumer');
    }

    public function userEdit(Request $request) {

        if ($request->id == Auth::user()->id) {

            if (User::where([
                    ['id', '<>', $request->id],
                    ['email', $request->email]
                ])->count() > 0) {
                $data = 'email_error';
            } else {
                $user = User::where('id', $request->id)->first();
                if ($request->name == '') {
                    $user->name = $user->name;
                } else {
                    $user->name = $request->name;
                }
                if ($request->email == '') {
                    $user->email = $user[0]->email;
                } else {
                    $user->email = $request->email;
                }

                $user->surname = $request->surname;
                $user->address = $request->address;
                
                $user->update();
                $data = $user;
            }
            
            
            echo json_encode($data);
        }
    }
}
