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
use App\Typeoption;
use App\Vendor;
use App\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        })->finaly()->orderBy('id', 'desc')->with('category')->with('manufacture')->paginate($itemsPerPage);

        $data = array (
            'title' => 'Товары',
            'products' => $products,
            'typeoptions' => Typeoption::get(),
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
            'typeoptions' => Typeoption::get(),
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

        if (isset($request->property_values)) {
            
            foreach ($request->property_values as $key => $newProperty) {
                if($newProperty != null) {
                    $propertyValue = new Propertyvalue;
                    $propertyValue->product_id = $product->id;
                    $propertyValue->property_id = $key;
                    $propertyValue->value = $newProperty;
    
                    $propertyValue->save();
                }                
            }
        }
        
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
            'typeoptions' => Typeoption::get(),
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
        $product->imported = 0;
        $product->save();
        
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
    public function destroy(Product $product, Request $request)
    {
        $route = ($request->route) ? 'admin.' . $request->route : 'admin.products.index';

        foreach ($product->images as $image) {
            // удаляем изображение только если оно не принадлежит больше ни одному продукту
            if ($image->products->count() === 1) {
                if (file_exists(public_path('imgs/products/'.$image->image))) {
                    try {
                        $file = new Filesystem;
                        $file->delete(public_path('imgs/products/'. $image->image));
                    } catch (\Throwable $th) {
                        echo 'Сообщение: '   . $th->getMessage() . '<br />';
                    }
                }
                if (file_exists(public_path() .'/imgs/products/thumbnails/' . $image->thumbnail)) {
                    try {
                        $file = new Filesystem;
                        $file->delete(public_path().'/imgs/products/thumbnails/' . $image->thumbnail);
                    } catch (\Throwable $th) {
                        echo 'Сообщение: '   . $th->getMessage() . '<br />';
                    }
                }

                $product->images()->detach($image);
                Image::where('id', $image->id)->delete();
            }
        }     
        
        $product->delete();


        return redirect()->route($route);
    }

    public function showInCategory($categoryId) {
        echo ($categoryId);
    }

    public function copy(Request $request) {

        if (isset($request->product_group_ids) && count($request->product_group_ids) > 0) {
            $products = Product::whereIn('id', $request->product_group_ids)->with('propertyvalue')->with('images')->get();
        
            $property_values = [];
            foreach ($products as $key => $product) {
                foreach ($product->propertyvalue as $key => $value) {
                    $property_values[$value->property_id] = $value->value;
                }

                $count = 2;
                while (Product::where('product', $product->product . ' (' . $count . ')')->count() > 0) {
                    $count++;
                }

                $data_to_product = [
                    'product' => $product->product . ' (' . $count . ')',
                    'scu' => $product->scu,
                    'category_id' => $product->category_id,
                    'manufacture_id' => $product->manufacture_id,
                    'vendor_id' => $product->vendor_id,
                    'product_pricename' => $product->product_pricename,
                    'unit_id' => $product->unit_id,
                    'discount_id' => $product->discount_id,
                    'size_l' => $product->size_l,
                    'size_w' => $product->size_w,
                    'size_t' => $product->size_t,
                    'size_type' => $product->size_type,
                    'mass' => $product->mass,
                    'short_description' => $product->short_description,
                    'description' => $product->description,
                    'delivery_time' => $product->delivery_time,
                    'meta_description' => $product->meta_description,
                    'meta_keywords' => $product->meta_keywords,
                    'published' => 0,
                    // 'published' => $product->published,
                    'pay_online' => $product->pay_online,
                    'packaging' => $product->packaging,
                    'unit_in_package' => $product->unit_in_package,
                    'amount_in_package' => $product->amount_in_package,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'quantity_vendor' => $product->quantity_vendor,
                    'profit' => $product->profit,
                    'profit_type' => $product->profit_type,
                    'incomin_price' => $product->incomin_price,
                    'propertyvalue' => $property_values,
                    'autoscu' => '',
                    'slug' => '',
                ];

                $new_product = Product::create($data_to_product);
                
                foreach ($property_values as $key => $value) {
                    if($value != null) {
                        $propertyValue = new Propertyvalue;
                        $propertyValue->product_id = $new_product->id;
                        $propertyValue->property_id = $key;
                        $propertyValue->value = $value;        
                        $propertyValue->save();
                    }
                }
                
                if ($product->images->count() > 0) {
                    foreach ($product->images as $key => $image) {
                        // $product->images()->attach($image->id);
                        $image->products()->attach($new_product->id);
                    }
                }                
            }

            return redirect()->back()->with('success', 'Товары успешно скопированы');
        } else {
            redirect()->back()->with('warning', 'Вы не выбрали товары для копирования');
        }        
    }

    public function published(Request $request) {
        if (isset($request->product_group_ids) && count($request->product_group_ids) > 0) {
            $products = Product::whereIn('id', $request->product_group_ids)->get();
        
            foreach ($products as $key => $product) {
                $product->update(['published' => '1']);
            }

            return redirect()->back()->with('success', 'Товары успешно опубликованы');
        } else {
            redirect()->back()->with('warning', 'Вы не выбрали товары для публикования');
        }   
    }

    public function unimported(Request $request) {
        if (isset($request->product_group_ids) && count($request->product_group_ids) > 0) {
            $products = Product::whereIn('id', $request->product_group_ids)->get();
        
            foreach ($products as $key => $product) {         
                $product->update(['imported' => 0]);
            }

            return redirect()->back()->with('success', 'Товары успешно перенесены в основной раздел');
        } else {
            redirect()->back()->with('warning', 'Вы не выбрали товары для переноса в основной раздел');
        }   
    }

    public function massDestroy(Request $request) {
        if (isset($request->product_group_ids) && count($request->product_group_ids) > 0) {
            $products = Product::whereIn('id', $request->product_group_ids)->with('propertyvalue')->get();
        
            foreach ($products as $key => $product) {
                foreach ($product->images as $image) {
                    // удаляем изображение только если оно не принадлежит больше ни одному продукту
                    if ($image->products->count() === 1) {
                        if (file_exists(public_path('imgs/products/'.$image->image))) {
                            try {
                                $file = new Filesystem;
                                $file->delete(public_path('imgs/products/'. $image->image));
                            } catch (\Throwable $th) {
                                echo 'Сообщение: '   . $th->getMessage() . '<br />';
                            }
                        }
                        if (file_exists(public_path() .'/imgs/products/thumbnails/' . $image->thumbnail)) {
                            try {
                                $file = new Filesystem;
                                $file->delete(public_path().'/imgs/products/thumbnails/' . $image->thumbnail);
                            } catch (\Throwable $th) {
                                echo 'Сообщение: '   . $th->getMessage() . '<br />';
                            }
                        }
        
                        $product->images()->detach($image);
                        Image::where('id', $image->id)->delete();
                    }
                }     
                
                $product->delete();
            }            
            return redirect()->back()->with('success', 'Товары успешно удалены');
        } else {
            redirect()->back()->with('warning', 'Вы не выбрали товары для удаления');
        }
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

    // public function export() {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $products = Product::published()->with(['category', 'manufacture', 'propertyvalue'])->get();
    //     $sheet->setCellValue('A1', 'Hello World !');
    //     $sheet->setCellValue('A4', '№');
    //     $sheet->setCellValue('B4', 'Код товара');
    //     $sheet->setCellValue('C4', 'Название, категория');
    //     $sheet->setCellValue('D4', 'Производитель');

    //     $count = 5;
    //     $number = 1;
    //     foreach ($products as $key => $product) {
    //         $sheet->setCellValue('A' . $count++, $number++);
    //         $sheet->setCellValue('B' . $count, $product->autoscu);
    //         if (isset($product->category)) {
    //             $sheet->setCellValue('C' . $count, $product->product . ' ' . $product->category->category);
    //         }
    //         if (isset($product->manufacture)) {
    //             $sheet->setCellValue('D' . $count, $product->manufacture->manufacture);
    //         }
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('products.xlsx');

    //     return 'ok';
    // }

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
