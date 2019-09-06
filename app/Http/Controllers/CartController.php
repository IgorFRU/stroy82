<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\OrderProduct;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addItems(Request $request) {

        if ($request->session()->has('session_id')) {
            $session_id = session('session_id');
        } else {
            $request->session()->put('session_id', Str::uuid());
        }

        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = 0;
        }

        if (Cart::where('product_id', $request->productId)->count() > 0) {
            $cart = Cart::where('product_id', $request->productId)->first();
            $cart->quantity += $request->quantity;
            $cart->update();
        } else {
            $cart_data = [
                'product_id' => $request->productId,
                'quantity' => $request->quantity,
                'user_id' => $user_id,
                'session_id' => session('session_id'),
            ];
            
            $cart = Cart::create($cart_data);
        }
        
        // $cart = Cart::where('session_id', session('session_id'))->get();
        
        $product = Product::where('id', $cart->product_id)->first();
        
        if ($product->actually_discount) {
            $price = $product->discount_price;
        } else {
            $price = $product->price;
        }

        $category = $product->category->category;
        $categorySlug = $product->category->slug;
        $sum = number_format($cart->quantity * $price, 2, ',', ' ');
        
        $to_cart = [
            'id' => $product->id,
            'product' => $product->product,
            'productSlug' => $product->slug,
            'quantity' => $cart->quantity,
            'img' => $product->main_or_first_image,
            'price' => $price,
            'sum' => $sum,
        ];
        // if (isset($request->userId)) {
        //     $user = $request->userId;
        // } else {
        //     $user = $request->ip();
        // }

        // $userProduct = $user . '_product_' . $request->productId;
        // $quantity = round($request->quantity, 2);

        // if ($request->session()->has($userProduct)) {
        //     $oldQuantity = session($userProduct);
        //     $quantity += $oldQuantity;
        //     $request->session()->put($userProduct, round($quantity, 2));
        // } else {
        //     $request->session()->put($userProduct, round($quantity, 2));
        // }
        
        // // $request->session()->forget($userProduct);
        // $data['product'] = $userProduct;
        // $data['quantity'] = $quantity;
        echo json_encode($to_cart);
        // echo json_encode(session('session_id'));
    }

    public function showCart(Request $request) {
        dd($request->all());
    }
}
