<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Cart;
use App\User;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Support\Facades\Hash;

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
        
        // dd($request->session('order'));
        // if ($request->session()->has('order') && session('order') != '') {
        //     $order = Order::where('number', session('order'))->firstOrFail();
        // } else {
            if (Auth::check()) {
                $user_id = Auth::id();
            } else {
                if (isset($request->phone) && $request->phone != '') {
                    $phone = $request->phone;
                    $phone = str_replace(array('+','-', '(', ')'), '', $phone);
                    if (strlen($phone) == 11) {
                        $phone = substr($phone, 1);
                    }
    
                    $user = User::where('phone', $phone)->first();
    
                    if ($user == NULL) {
                        $user_data = [
                            'quick'     => '1',
                            'name'      => $request->name,
                            'surname'   => $request->surname,
                            'address'   => $request->address,
                            'phone'     => $phone,
                            'password'  => '',
                            // 'password'  => Hash::make('Qq-123456'),
                        ];                
                        $user = User::create($user_data);
                    }
                $user_id = $user->id;
                }            
            }
            $today = Carbon::today()->locale('ru')->isoFormat('DD') . Carbon::today()->locale('ru')->isoFormat('MM') . Carbon::today()->locale('ru')->isoFormat('YY');
            $number = $today . '-' . mt_rand(1000, 9999);
            $request->session()->put('order', $number);
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
                'orderstatus_id' => Setting::firstOrFail()->orderstatus_id,
                'user_id' => $user_id,
                'firm_inn' => $firm_inn,
                'payment_method' => $request->payment_method,
                'successful_payment' => 0,
                'completed' => 0,
            ];
            
            $order = Order::create($order_data);

            if ($order) {
                $cart = Cart::where('finished', '0')->where([
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
        // }        

        $data = [
            'number' => $order->number,
        ];

        $messege = 'Заказ <a href="' . route('orderShow', $order->number) .'">№' . $order->number . '</a> успешно сформирован.';
        if (Auth::check()) {
            return redirect()->route('home')->with('success', $messege);
        } else {
            return redirect()->route('index')->with('success', $messege);
        }
        
        // return view('order_finish', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function showOrder($number, Request $request)
    {
        $order = Order::where('number', $number)->with('products')->FirstOrFail();
        $error = '';

        if (Auth::check()) {
            if ($order->user_id != Auth::user()->id) {
                $order = '';
                $error = 'У вас нет доступа к информации об этом заказе!';
            }
        } else {
            if (!$request->session()->has('order') || session('order') != $number) {
                $order = '';
            
                $error = 'У вас нет доступа к информации об этом заказе! Войдите в свою учётную запись и повторите попытку.';
            }
        }        
        
        $data = [
            'order' => $order,
            'error' => $error,
        ];

        // dd($data);

        return view('order_show', $data);
    }

    public function usersOrder($order)
    {
        $order = Order::where('number', $order)->FirstOrFail();
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

        // return view('user_order_show', $data);
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

    public function checkUserPhone(Request $request) {
        if (isset($request->phone) && $request->phone != '') {
            $phone = $request->phone;
            $phone = str_replace(array('+','-', '(', ')'), '', $phone);
            if (strlen($phone) == 11) {
                $phone = substr($phone, 1);
            }
        } else {
            $phone = '';
        }

        $users_count = User::where('phone', $phone)->where('quick', '0')->count();
        if ($users_count) {
            // return back()->withInput()
            // ->withErrors(array('phone_user' => 'Пользователь с таким номером телефона уже существует.'));
            echo json_encode(array('error' => true));
        } else {
            echo json_encode(array('phone' => $phone, 'error' => false));
        }     
    }

    public function changestatus(Request $request)
    {
        $order_id = $request->get('order_id');
        $order_change_complete = $request->get('order_change_complete');
        $order_change_status = $request->get('order_change_status');
        $order_change_payment_status = $request->get('order_change_payment_status');

        $order = Order::where('id', $order_id)->firstOrFail();
        $order->completed = $order_change_complete;
        $order->orderstatus_id = $order_change_status;
        $order->successful_payment = $order_change_payment_status;
        $order->update();
        if ($order) {
            echo json_encode('success');
        } else {
            echo json_encode('error');
        }
    }

    //ajax
    public function checkOrderStatus(Request $request) {
        $order_number = $request->get('check_order_status__number');
        $phone = $request->get('check_order_status__phone');

        dd($order_number, $phone);
    }
}
