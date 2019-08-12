<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use App\ImageProduct;
use App\Category;
use App\Manufacture;
use App\Discount;
use App\Vendor;
use App\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

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
        } elseif (isset($request->article)) {
            echo 'Товары из статьи ' . $request->article;
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
        $today = Carbon::now();
        $data = array (
            'product' => [],
            //коллекция вложенных подкатегорий
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'manufactures' => Manufacture::get(),
            'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
            'vendors' => Vendor::get(),
            'units' => Unit::get(),
            'typeRequest' => 'create',       //тип запроса - создание или редактирование, чтобы можно было менять action формы
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
        // dd($request->all());
        $product = Product::create($request->all());
        // dd($product);
        
        // return redirect()->route('admin.products.index')
        //     ->with('success', 'Категория успешно добавлена.');
        return redirect()->route('admin.products.index', $product);
    }

    public function storeAjax(Request $request)
    {
        // dd($request->all());
        $product = Product::create($request->all());
        // $product->slug = $product->product;
        
        // return redirect()->route('admin.products.index')
        //     ->with('success', 'Категория успешно добавлена.');

        // return redirect()->route('admin.products.addImages', $product);
        // return response()->view('admin.products.addImages', $product);
        echo json_encode(array('id' => $product->id));
        // return response('Hello World', 200);
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
    public function edit(Product $product, $addImages = null)
    {
        $today = Carbon::now();
        $data = array (
            'product' => $product,
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'manufactures' => Manufacture::get(),
            'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
            'vendors' => Vendor::get(),
            'units' => Unit::get(),
            'typeRequest' => 'edit',
            'delimiter' => ''
        );
        
        return view('admin.products.edit', $data);
    }

    public function addImages(Product $product)
    {
        // dd($product);
        $today = Carbon::now();
        $data = array (
            'product' => $product,
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'manufactures' => Manufacture::get(),
            'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
            'vendors' => Vendor::get(),
            'units' => Unit::get(),
            'typeRequest' => 'edit',
            'delimiter' => '',
            'addImages' => true,
        );
        
        return view('admin.products.edit', $data);
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
        $product->update($request->except('alias'));

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // dd($product->images);

        // $images = ImageProduct::where('product_id', $product->id)->get();
        // foreach ($images as $image) {
        //     echo $image->images->image;
        //     echo '<br>';
        // }
        
        $images = ImageProduct::where('product_id', $product->id)->get();
        $imagesIdArray = $images->pluck('image_id');
        
        foreach ($images as $image) {
            // echo $image->image;
            // echo '<br>';
            if (file_exists(public_path('imgs/products/'.$image->image))) {
                try {
                    unlink(public_path('imgs/products/'.$image->image));
                } catch (\Throwable $th) {
                    //echo 'Сообщение: '   . $th->getMessage() . '<br />';
                }                
            }
            if (file_exists(public_path('imgs/products/thumbnails/'.$image->thumbnail))) {
                try {
                    unlink(public_path('imgs/products/thumbnails/'.$image->thumbnail));
                } catch (\Throwable $th) {
                    //echo 'Сообщение: '   . $th->getMessage() . '<br />';
                }                
            }
        }

        if ($product->images->count()) {
            $product->images()->detach($images);   
            Image::whereIn('id', $imagesIdArray)->delete();     
        }        
        
        $product->delete();

        return redirect()->route('admin.products.index');

        // dd($imagesArray);

        // $product->images()->detach($images);


        // foreach ($product->images as $key => $image) {
        //     $oneImage = Image::where('image', $image->image);
        //     echo $oneImage->count();
        //     if ($oneImage->count() == 1) {

        //     }
        // }

        // unlink(public_path('imgs/products/'.$proruct->images));
        // $category->delete();

        // return redirect()->route('admin.categories.index')->with('success', 'Категория успешно удалена');
    }

    public function showInCategory($categoryId) {
        echo ($categoryId);
    }
}
