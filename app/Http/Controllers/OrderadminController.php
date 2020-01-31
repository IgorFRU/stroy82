<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\User;

use Illuminate\Http\Request;

class OrderadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function adminActiveOrders() {
        $orders = Order::active()->with('consumers', 'status')->get();

        // dd($orders);
        $data = array(
            'orders' => $orders,
        );

        return view('admin.orders.active', $data);
    }
}
