<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use App\ImageProduct;
use App\ArticleProduct;
use App\Category;
use App\Manufacture;
use App\Discount;
use App\Vendor;
use App\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

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
            $category = $request->category;
        } else {
            $category = 0;
        }
        if (isset($request->manufacture)) {
            $manufacture = $request->manufacture;
        } else {
            $manufacture = 0;
        }

        $products = Product::
        when($category, function ($query, $category) {
            return $query->where('category_id', $category);
        })
        ->when($manufacture, function ($query, $manufacture) {
            return $query->where('manufacture_id', $manufacture);
        })->with('category')->with('manufacture')->paginate(2);

        $data = array (
            'products' => $products,
            'categories' => Category::with('children')->where('category_id', '0')->orderBy('category', 'asc')->get(),
            'delimiter' => '',
            'current_category' => $category,
            'current_manufacture' => $manufacture,
            'manufactures' => Manufacture::get(),
        ); 
        return view('admin.products.index', $data);
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
        
        if (isset($request->image_id)) {
            $imagesArray = $request->image_id;
            
            foreach ($imagesArray as $image) {
                $imageCollection = Image::where('id', $image)->first();
                $old_name = $imageCollection->image;
                $new_name = Str::after($old_name, '-noprod-');
                $old_thumbnail = $imageCollection->thumbnail;
                $new_thumbnail = Str::after($old_thumbnail, '-noprod-');
                rename(public_path("imgs/products/". $old_name), public_path("imgs/products/". $new_name));
                rename(public_path("imgs/products/thumbnails/". $old_thumbnail), public_path("imgs/products/thumbnails/". $new_thumbnail));
                $imageCollection->image = $new_name;
                $imageCollection->thumbnail = $new_thumbnail;
                $imageCollection->update();
                $product->images()->attach($image);
            } 
        }
        
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

    // public function addImages(Product $product)
    // {
    //     // dd($product);
    //     $today = Carbon::now();
    //     $data = array (
    //         'product' => $product,
    //         'categories' => Category::with('children')->where('category_id', '0')->get(),
    //         'manufactures' => Manufacture::get(),
    //         'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
    //         'vendors' => Vendor::get(),
    //         'units' => Unit::get(),
    //         'typeRequest' => 'edit',
    //         'delimiter' => '',
    //         'addImages' => true,
    //     );
        
    //     return view('admin.products.edit', $data);
    // }

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
        
        if (isset($request->image_id)) {
            $imagesArray = $request->image_id;
            
            foreach ($imagesArray as $image) {
                $imageCollection = Image::where('id', $image)->first();
                $old_name = $imageCollection->image;
                $new_name = Str::after($old_name, '-noprod-');
                $old_thumbnail = $imageCollection->thumbnail;
                $new_thumbnail = Str::after($old_thumbnail, '-noprod-');
                rename(public_path("imgs/products/". $old_name), public_path("imgs/products/". $new_name));
                rename(public_path("imgs/products/thumbnails/". $old_thumbnail), public_path("imgs/products/thumbnails/". $new_thumbnail));
                $imageCollection->image = $new_name;
                $imageCollection->thumbnail = $new_thumbnail;
                $imageCollection->update();
                $product->images()->attach($image);
            } 
        }

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
        $images = ImageProduct::where('product_id', $product->id)->get();
        $imagesIdArray = $images->pluck('image_id');
        foreach ($images as $image) {
            if (file_exists(public_path('imgs/products/'.$image->images->image))) {
                try {
                    $file = new Filesystem;
                    $file->delete(public_path('imgs/products/'. $image->images->image));
                } catch (\Throwable $th) {
                    echo 'Сообщение: '   . $th->getMessage() . '<br />';
                }                
            }
            if (file_exists(public_path() .'\imgs\products\thumbnails\\' . $image->images->thumbnail)) {
                try {
                    $file = new Filesystem;
                    $file->delete(public_path().'\imgs\products\thumbnails\\' . $image->images->thumbnail);
                } catch (\Throwable $th) {
                    echo 'Сообщение: '   . $th->getMessage() . '<br />';
                }                
            }
        }

        if ($product->images->count()) {
            $product->images()->detach($images);   
            Image::whereIn('id', $imagesIdArray)->delete();     
        }        
        
        $product->delete();

        return redirect()->route('admin.products.index');
    }

    public function showInCategory($categoryId) {
        echo ($categoryId);
    }

    public function ajaxSearch(Request $request) {
        $json = array();

        if (isset($request->article)) {
            $article = $request->article;
            $articleProducts = ArticleProduct::where('article_id', $article)->pluck('product_id');
        } else {
            $articleProducts[] = 0;
        }        
        
        // if (strlen($request->product) > 3) {
        //     // $json = array();
        //     $products = Product::where('product', 'like', '%' . $request->product . '%')
        //                         ->whereNotIn('id', $articleProducts)->get();
        //     if ($products) {
        //         // echo json_encode(array('products' => $product));
        //         foreach ($products as $key => $product) {
        //             // $json['content'] = $product;
                    
        //             $json[$key] = $product;
        //         }    
        //         if (count($json)) {
        //             echo json_encode($json);
        //         } else {
        //             $json[0] = 'Ничего не найдено';
        //             echo json_encode($json);
        //             // echo json_encode(array('msg' => 'Ничего'));
        //         }
        //     } else {
        //         echo json_encode(array('msg' => 'Ничего не найдено'));
        //         // $json['msg'] = 'Ничего не найдено';
        //         // echo json_encode($json);
        //     }            
        // }

        if (isset($request->category) && $request->category != 0) {
            $products = Product::where('category_id', $request->category)
                                ->whereNotIn('id', $articleProducts)->get();
            if ($products) {
                // echo json_encode(array('products' => $product));
                foreach ($products as $key => $product) {
                    // $json['content'] = $product;
                    
                    $json[$key] = $product;
                }    
                if (count($json)) {
                    echo json_encode($json);
                } else {
                    $json[0] = 'Ничего не найдено';
                    echo json_encode($json);
                    // echo json_encode(array('msg' => 'Ничего'));
                }
            } else {
                echo json_encode(array('msg' => 'Ничего не найдено'));
                // $json['msg'] = 'Ничего не найдено';
                // echo json_encode($json);
            }
        }
        // echo json_encode(array('response' => $request->product));
        // echo json_encode($request->all());
    }
}
