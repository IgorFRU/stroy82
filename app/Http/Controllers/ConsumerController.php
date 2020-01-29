<?php

namespace App\Http\Controllers;

use App\Consumer;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConsumerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumers = User::orderBy('id', 'DESC')->paginate(40);

        $data = array (
            'consumers' => $consumers,
        );

        return view('admin.consumers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function show(Consumer $consumer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumer $consumer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consumer $consumer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consumer $consumer)
    {
        //
    }

    public function consumer($id) 
    {
        $consumer = User::where('id', $id)->with('orders')->firstOrFail();

        $data = array(
            'consumer' => $consumer,
        );

        return view('admin.consumers.consumer', $data);
    }

    public function order($consumer, $order)
    {
        $consumer = User::where('id', $consumer)->firstOrFail();
        $order = Order::where('number', $order)->with('products')->firstOrFail();

        if ($order->unread) {
            $order->read_at = Carbon::now();
            $order->update();
        }

        $data = array(
            'consumer' => $consumer,
            'order' => $order,
        );

        return view('admin.consumers.order', $data);
    }
}
