<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Admin;
use App\User;
use App\Order;
use App\Orderstatus;
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
        $orderstatus = Orderstatus::first();
        if ($orderstatus == NULL) {
            $orderstatus = Orderstatus::create(
                [
                    'orderstatus'   => 'Ожидает обработки',
                    'color'         => '#ffed4a',
                    'icon'          => '<i class="fas fa-clock"></i>'
                ]
            );
        }

        $settings = Setting::first();
        if ($settings == NULL) {
            $settings = Setting::create(
                [
                    'site_name'        => 'Строительный магазин "Stroy82"',
                    'address'          => '',
                    'phone_1'          => '',
                    'phone_2'          => '',
                    'email'            => 'info@stroy82.com',
                    'viber'            => '',
                    'whatsapp'         => '',
                    'main_text'        => '',
                    'orderstatus_id'   => $orderstatus->id
                ]
            );
        }

        $data = [
            'settings' => $settings,
            'one_admin' => Auth::user(),
            'admins' => Admin::get(),
            'orders' => Order::unreadlast(5)->get(),
            'users' => User::last(5)->get(),
        ];

        // dd(Order::unread()->get()->limit(5));
        // dd($data['settings']);
        return view('admin', $data);
        // echo ('is admin');
    }

    public function settings(Request $request) {
        // dd($request);
        $settings = Setting::first();
        $settings->update($request->all());

        return redirect()->route('admin.index');
    }
}
