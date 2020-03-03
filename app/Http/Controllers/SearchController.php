<?php

namespace App\Http\Controllers;

use App\Category;
use App\Manufacture;
use App\Product;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function quickSearch(Request $request) {
        $categories = Category::where('category', 'like', '%' . $request->q . '%')->limit(5)->get();
        $products = Product::where('product', 'like', '%' . $request->q . '%')->with('category')->published()->limit(5)->get();
        $manufactures = Manufacture::where('manufacture', 'like', '%' . $request->q . '%')->limit(5)->get();

        echo json_encode(array(
            'categories' => $categories,
            'products' => $products,
            'manufactures' => $manufactures,
        ));
    }

    public function search(Request $request) {
        $categories = Category::where('category', 'like', '%' . $request->q . '%')->get();
        $products = Product::where('product', 'like', '%' . $request->q . '%')->with('category', 'manufacture', 'unit')->published()->get();
        $manufactures = Manufacture::where('manufacture', 'like', '%' . $request->q . '%')->get();

        $data = [
            'categories' => $categories,
            'products' => $products,
            'manufactures' => $manufactures,
        ];

        return view('searchresult', $data);
    }
}
