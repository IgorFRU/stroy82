<?php

namespace App\Http\Controllers;

use App\Product;
use App\Property;
use App\Propertyvalue;
use App\Image;
use App\ImageProduct;
use App\ArticleProduct;
use App\ProductSet;
use App\Category;
use App\Manufacture;
use App\Discount;
use App\Vendor;
use App\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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
        $minutes = 2;
        
        $category = (isset($_COOKIE['adm_category_show'])) ? $category = $_COOKIE['adm_category_show'] : $category = 0;
        $manufacture = (isset($_COOKIE['adm_manufacture_show'])) ? $manufacture = $_COOKIE['adm_manufacture_show'] : $manufacture = 0;
        $itemsPerPage = (isset($_COOKIE['adm_items_per_page'])) ? $itemsPerPage = $_COOKIE['adm_items_per_page'] : $itemsPerPage = 20;
        $show_published = (isset($_COOKIE['adm_show_published'])) ? $show_published = $_COOKIE['adm_show_published'] : $show_published = 0;

        if (isset($request->category)) {
            $category = $request->category;
        }

        $products = Product::
        when($category, function ($query, $category) {
            return $query->where('category_id', $category);
        })
        ->when($show_published, function ($query, $show_published) {
            if ($show_published == 1) {
                return $query->where('published', 1);
            } elseif($show_published == 2) {
                return $query->where('published', 0);
            }
        })
        ->when($manufacture, function ($query, $manufacture) {
            return $query->where('manufacture_id', $manufacture);
        })->orderBy('id', 'desc')->with('category')->with('manufacture')->paginate($itemsPerPage);

        $data = array (
            'title' => 'Товары',
            'products' => $products,
            'categories' => Category::with('children')->where('category_id', '0')->orderBy('category', 'asc')->get(),
            'delimiter' => '',
            'current_category' => $category,
            'current_manufacture' => $manufacture,
            'manufactures' => Manufacture::get(),
        ); 
        // dd($data);
        // dd($data['categories']);
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
            'title' => 'Новый товар',
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
        if (isset($product->category->property)) {
            $properties = $product->category->property;
        } else {
            $properties = array();
        }
        
        $data = array (
            'title' => 'Редактирование товара',
            'product' => $product,
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'manufactures' => Manufacture::get(),
            'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
            'vendors' => Vendor::get(),
            'units' => Unit::get(),
            'properties' => $properties,
            'propertyvalues' => Propertyvalue::where('product_id', $product->id)->pluck('value', 'property_id'),
            'typeRequest' => 'edit',
            'delimiter' => ''
        );
        // dd($data['propertyvalues']);
        
        // dd($rr->category->first()->id);
        
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
        // dd($request->all());
        if (isset($request->property_values)) {
            $newProperties = $request->property_values;
            // dd($newProperties);
            $oldProperties = Propertyvalue::where('product_id', $product->id)->get();
            $oldPropertiesArray = $oldProperties->pluck('value', 'property_id');
            $oldKeys = array();
            foreach ($oldPropertiesArray as $key => $oldProperty) {
                if (isset($newProperties["$key"])) {
                    if ($newProperties["$key"] != $oldProperty) {
                        $toUpdate = $oldProperties->where('property_id', $key)->first();
                        $toUpdate->value = $newProperties["$key"];
                        $toUpdate->update();
                    }
                } else {
                    $toDelete = $oldProperties->where('property_id', $key)->first();
                    $toDelete->delete();
                }
                $oldKeys[] = $key;
                // dd($oldKeys);
            }

            foreach ($oldKeys as $oldKey) {
                $newProperties = Arr::except($newProperties, ["$oldKey"]);
                // dd($oldKey);
            }
            // dd($newProperties);
            foreach ($newProperties as $key => $newProperty) {
                // dd($key);
                if($newProperty != null) {
                    $propertyValue = new Propertyvalue;
                    $propertyValue->product_id = $product->id;
                    $propertyValue->property_id = $key;
                    $propertyValue->value = $newProperty;
    
                    $propertyValue->save();
                }
                
            }
        }
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

        if (isset($request->object)) {
            $object = $request->object;
            if (isset($request->objectType) && $request->objectType == 'article') {
                $objectProducts = ArticleProduct::where('article_id', $object)->pluck('product_id');
            } else if (isset($request->objectType) && $request->objectType == 'set') {
                $objectProducts = ProductSet::where('set_id', $object)->pluck('product_id');
            }
            
            
        } else {
            $objectProducts[] = 0;
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
                                ->whereNotIn('id', $objectProducts)->get();
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

    public function getCategoryProperties(Request $request) {

        $category = Category::whereId($request->category_id)->with('property')->firstOrFail();
        echo json_encode($category->property);
    }

    public function setCookie(Request $request) {
        if (isset($request->adm_category_show) && $request->adm_category_show != '') {
            setcookie('adm_category_show', $request->adm_category_show, time()+60*60*24*365);
        }
        if (isset($request->adm_manufacture_show) && $request->adm_manufacture_show != '') {
            setcookie('adm_manufacture_show', $request->adm_manufacture_show, time()+60*60*24*365); 
        }
        if (isset($request->adm_items_per_page) && $request->adm_items_per_page != '') {
            setcookie('adm_items_per_page', $request->adm_items_per_page, time()+60*60*24*365); 
        }
        if (isset($request->adm_show_published) && $request->adm_show_published != '') {
            setcookie('adm_show_published', $request->adm_show_published, time()+60*60*24*365); 
        }
        // echo json_encode($name);
    }
}
