<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Manufacture;
use App\Discount;
use App\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
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
    public function index(Request $request)
    {
        
        if (isset($request->category)) {
            $data = array (
                'products' => Product::where('category_id', $request->category)->orderBy('id', 'DESC')->get(),
                'parent_category' => Category::where('id', $request->category)->pluck('category')[0],
                'categories' => Category::orderBy('id', 'DESC')->get(),
            );
            return view('admin.products.index', $data);
        } elseif (isset($request->manufacture)) {
            echo 'Товары производителя ' . $request->manufacture;
        } else {
            $data = array (
                'products' => Product::orderBy('id', 'DESC')->get(),
                'categories' => Category::orderBy('id', 'DESC')->get(),
            );    
            return view('admin.products.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'product' => [],
            //коллекция вложенных подкатегорий
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'manufactures' => Manufacture::get(),
            'discounts' => Discount::get(),
            'vendors' => Vendor::get(),
            //символ, обозначающий вложенность категорий
            'delimiter' => ''
        );
        // dd($data['categories']);
        
        return view('admin.products.create', $data);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function showInCategory($categoryId) {
        echo ($categoryId);
    }
}
