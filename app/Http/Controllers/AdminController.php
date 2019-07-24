<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Admin;
use App\User;
use App\Order;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'settings' => Setting::first(),
            'one_admin' => Auth::user(),
            'admins' => Admin::get(),
            'orders' => Order::unread()->last(5)->get(),
            'users' => User::last(5)->get(),
        ];
        // dd($data['orders']);
        return view('admin', $data);
        // echo ('is admin');
    }
}
