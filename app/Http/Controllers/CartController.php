<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItems(Request $request) {
        
        if (isset($request->userId)) {
            $user = $request->userId;
        } else {
            $user = $request->ip();
        }

        $userProduct = $user . '_product_' . $request->productId;
        $quantity = round($request->quantity, 2);

        if ($request->session()->has($userProduct)) {
            $oldQuantity = session($userProduct);
            $quantity += $oldQuantity;
            $request->session()->put($userProduct, round($quantity, 2));
        } else {
            $request->session()->put($userProduct, round($quantity, 2));
        }
        
        // $request->session()->forget($userProduct);
        $data['product'] = $userProduct;
        $data['quantity'] = $quantity;
        echo json_encode($data);
    }

    public function showCart(Request $request) {
        dd($request->all());
    }
}
