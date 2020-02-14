<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\User;
use App\Orderstatus;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'title' => 'Статусы заказов',
            'orders' => $orders,
        );

        return view('admin.orders.active', $data);
    }

    public function order($order)
    {
        $order = Order::where('number', $order)->with('products', 'status')->firstOrFail();

        if ($order->unread) {
            $order->read_at = Carbon::now();
            $order->update();
        }

        $orderstatuses = Orderstatus::orderBy('id', 'ASC')->get();

        $data = array(
            'title' => 'Статус заказов',
            'order' => $order,
            'statuses' => $orderstatuses,
        );

        return view('admin.orders.order', $data);
    }

    public function adminHotOrders() {
        $orders = Order::unread()->active()->with('consumers', 'status')->get();

        // dd($orders);
        $data = array(
            'title' => 'Новые заказы',
            'orders' => $orders,
        );

        return view('admin.orders.hot', $data);
    }

    public function adminArchiveOrders() {
        $orders = Order::archive()->with('consumers', 'status')->get();

        $data = array(
            'title' => 'Архив заказов',
            'orders' => $orders,
        );

        return view('admin.orders.archive', $data);
    }
}
