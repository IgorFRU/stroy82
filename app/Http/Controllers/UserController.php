<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;

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
        $data = [
            'orders' => Order::where([
                ['user_id', Auth::user()->id],
                ['completed', 0]
            ])->get(),
        ];
        return view('home', $data);
        // echo ('consumer');
    }

    public function userEdit(Request $request) {

        if ($request->id == Auth::user()->id) {

            $user = Auth::user();
            if ($request->name == '') {
                $user->name = $user->name;
            } else {
                $user->name = $request->name;
            }
            if ($request->email == '' || User::where([
                ['id', '<>', $request->id],
                ['email', $request->email]
            ])->count() > 0) {
                $user->email = $user->email;
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
