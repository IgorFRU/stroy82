<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Cart;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Fomvasss\Dadata\Facades\DadataSuggest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user()->with('firms')->first();;
        } else {
            $user = '';
        } 
        $data = [
            'user' => $user,
        ];

        // dd($user);
        return view('order', $data);
    }

    public function usersOrders() {
        $orders = Order::where('user_id', Auth::user()->id)->get();

        $data = [
            'orders' => $orders,
        ];

        return view('order_list', $data);
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
        // dd($request->all());
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = 0;
        }

        $today = Carbon::today()->locale('ru')->isoFormat('DD') . Carbon::today()->locale('ru')->isoFormat('MM') . Carbon::today()->locale('ru')->isoFormat('YY');
        $number = $today . '-' . mt_rand(1000, 9999);
        while (Order::where('number', $number)->count() > 0) {
            $number = $today . '-' . mt_rand(1000, 9999);
        }

        if ($request->payment_method == 2) { //безнал
            $firm_inn = $request->firm_inn;
        } else {
            $firm_inn = 0;
        }

        $order_data = [
            'number' => $number,
            'orderstatus_id' => Setting::first()->pluck('orderstatus_id')[0],
            'user_id' => $user_id,
            'firm_inn' => $firm_inn,
            'payment_method' => $request->payment_method,
            'successful_payment' => 0,
            'completed' => 0,
        ];
        
        $order = Order::create($order_data);

        if ($order) {
            $cart = Cart::where([
                ['user_id', $user_id],
                ['session_id', session('session_id')]
            ])->get();

            foreach ($cart as $item) {
                if ($item->product->actually_discount) {
                    $price = $item->product->discount_price;
                } else {
                    $price = $item->product->price;
                }
                $order->products()->attach($item->product->id, ['amount' => $item->quantity, 'price' => $price]);
                $item->finished = 1;
                $item->update();
            }
        }

        $data = [
            'number' => $number,
        ];
        
        return view('order_finish', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function showOrder($order)
    {
        $order = Order::where('number', $order)->first();
        $error = '';

        if (Auth::check()) {
            if ($order->user_id != Auth::user()->id) {
                $order = '';
            }
        } else {
            $error = 'Для доступа к этому разделу необходимо авторизоваться';
        }
        
        
        
        $data = [
            'order' => $order,
            'error' => $error,
        ];

        // dd($data);

        return view('order_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function checkinn(Request $request) {
        // $curl = curl_init();
        
        // curl_setopt($curl, CURLOPT_URL, 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party');
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $request->inn);
        // $out = curl_exec($curl);
        // echo $out;
        // curl_close($curl);

        
        // curl -X POST \
        // -H "Content-Type: application/json" \
        // -H "Accept: application/json" \
        // -H "Authorization: Token 0acfff1725118a7a8649e798e57ea4eb903cbf25" \
        // -d '{ "query": "сбербанк" }' \
        

        // $r = curl_exec($ch);
        // echo '<pre>';
        // print_r(json_decode($r, true));
        // $result = DadataSuggest::suggest($request->inn);

        $result = DadataSuggest::suggest("party", ["query"=>$request->inn]);
        // print_r($result);

        echo json_encode($result);
    }

}
