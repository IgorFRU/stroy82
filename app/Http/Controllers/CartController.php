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
            $session_id = session('session_id');
        }

        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = 0;
        }

        if (Cart::where('session_id', $session_id)->count() == 0) {
            $cart_data = [
                'product_id' => $request->productId,
                'quantity' => $request->quantity,
                'user_id' => $user_id,
                'session_id' => session('session_id'),
            ];
            
            $cart = Cart::create($cart_data);
        } else {
            if (Cart::where([
                    ['product_id', $request->productId],
                    ['session_id', $session_id]
                ])->count() > 0) {
                $cart = Cart::where([
                    ['product_id', $request->productId],
                    ['session_id', $session_id]
                ])->first();
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
        }
        
        
        
        // $cart = Cart::where('session_id', session('session_id'))->get();
        
        // $product = Product::where('id', $cart->product_id)->first();
        $product = Product::where('id', $cart->product_id)->first();
        
        if ($product->actually_discount) {
            $price = $product->discount_price;
        } else {
            $price = $product->price;
        }

        //$category = $product->category->category;
        
        if (isset($product->category->slug)) {
            $categorySlug = $product->category->slug;
        } else {
            $categorySlug = '';
        }

        if (isset($product->unit->unit)) {
            $unit = $product->unit->unit;
        } else {
            $unit = '';
        }
        
        $sum = number_format($cart->quantity * $price, 2, ',', ' ');

        $total_sum = 0;

        $carts = Cart::where('session_id', session('session_id'))->get();
        $carts_array = $carts->pluck('quantity', 'product_id');
        $products_id = $carts->pluck('product_id');
        $products = Product::whereIn('id', $products_id)->with('discount')->get();

        if (isset($products) && count($products) > 0) {
            foreach ($products as $key => $productItem) {
                if($productItem->actually_discount) {
                    $total_sum += round($carts_array[$productItem->id] * $productItem->discount_price, 2);
                } else {
                    $total_sum += round($carts_array[$productItem->id] * $productItem->price, 2);
                }
            }
        }


        
        $to_cart = [
            'id'            => $request->productId,
            'product'       => $product->product,
            'productSlug'   => $product->slug,
            'categorySlug'  => $categorySlug,
            'quantity'      => $cart->quantity,
            'img'           => $product->main_or_first_image,
            'price'         => $price,
            'sum'           => $sum,
            'unit'          => $unit,
            'total_sum'     => number_format(round($total_sum, 2), 2, ',', ' '),
        ];
        
        // echo json_encode($cart);
        echo json_encode($to_cart);
        // echo json_encode(session('session_id'));
    }

    public function showCart(Request $request) {
        dd($request->all());
    }
}
