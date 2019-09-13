<?php

namespace App\Http\Controllers;

use App\Order;
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
        return view('order');
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
        dd($request->all());
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = 0;
        }

        $today = Carbon::today()->locale('ru')->isoFormat('DD') . Carbon::today()->locale('ru')->isoFormat('MM');
        $number = $today . '-' . mt_rand(1000, 9999);
        while (Order::where('number', $number)->count() > 0) {
            $number = $today . '-' . mt_rand(100, 999);
        }

        // dd($number);

        // $order_data = [
        //     'number' => $today . '-' . mt_rand(100, 999),
        //     'quantity' => $request->quantity,
        //     'user_id' => $user_id,
        //     'user_ip' => $user_ip,
        //     'session_id' => session('session_id'),
        // ];
        // 
        // $cart = Order::create($order_data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
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

    public function firmStore(Request $request) {

        echo json_encode($request->all());
    }
}
