<?php

namespace App\Http\Controllers;

use App\Article;
use App\Discount;
use App\Product;
use App\Property;
use App\Propertyvalue;
use App\Manufacture;
use App\Category;
use App\Set;
use App\Setting;
use App\Topmenu;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index() {
        $today = Carbon::now()->toDateString();
        $discount_ids = array();
        $discount_not_ids = array();
        $discountAllIds = array();
        $discountProductsCount = 0;
        
        $discounts = Discount::orderBy('discount_end', 'ASC')->where('discount_end', '>=', $today)->first();
        // dd($discounts->discount_end, $today->toDateString());
        // dd($discounts->id);
        // dd($discounts->discount_end->toDateString());
        
        if (isset($discounts)) {
            $discountProductsCount = $discounts->priced_products->where('published', 1)->count();
            // dd($discounts->priced_products->where('published', 1)->count());
            while ($discountProductsCount <= 2) {
                if ($discounts->priced_products->where('published', 1)->count() == 0) {
                    $discount_not_ids[] = $discounts->id;
                }
                else {
                    $discount_ids[] = $discounts->id;
                } 
                $discountAllIds[] = $discounts->id;
                // dd($discountAllIds);
                $discounts = Discount::orderBy('discount_end', 'ASC')->whereNotIn('id', $discountAllIds)->where('discount_end', '>=', $today)->first();
                if (!isset($discounts)) {
                    break;
                }
            }
            // dd(count($discount_not_ids));
            // dd($discount_ids);
            $discounts = Discount::orderBy('discount_end', 'ASC')->whereIn('id', $discount_ids)->where('discount_end', '>=', $today)->get();
        } else {
            $discounts = null;
        }
        $hour = 60;
        $categories = Cache::remember('categories', $hour, function() {
            return Category::orderBy('category', 'ASC')->where('category_id', 0)->get();
        });
        // dd($discounts);
        $data = array (
            'articles' => Article::orderBy('id', 'DESC')->limit(4)->get(),
            'discounts' => $discounts,
            'lastProducts' => Product::orderBy('id', 'DESC')->limit(4)->get(),
            'about' => Setting::find(1)->first(),
            'categories' => $categories,
        );
        // dd($data['lastProducts']);
        // dd($discounts->last_products);
        return view('welcome', $data);
    }

    public function staticpage($slug) {
        $staticpage = Topmenu::where('slug', $slug)->FirstOrFail();
        if(isset($staticpage)) {
            $staticpage->increment('views', 1);
        }
        
        $data = array (
            'staticpage' => $staticpage,
        );

        return view('staticpage', $data);
    }

    public function category($slug, Request $request) {
        // dd($slug);
        if (isset($request->prop)) {
            $prop = $request->prop;
        } else {
            $prop = 0;
        }
        

        // $products = Product::
        // when($category, function ($query, $category) {
        //     return $query->where('category_id', $category);
        // })
        // ->when($manufacture, function ($query, $manufacture) {
        //     return $query->where('manufacture_id', $manufacture);
        // })->orderBy('id', 'desc')->with('category')->whereIn('published', $published)->with('manufacture')->paginate($itemsPerPage);

        // dd($request->all());

        if ($prop != 0) {
            // dd($prop);
        }

        $category = Category::where('slug', $slug)->with('property')->firstOrFail();
        $products = Product::orderBy('id', 'DESC')->where('category_id', $category->id)->get();

        if ($prop) {

            $prop_products_array = [];
            $prop_array = [];

            $new_array = [];
            foreach ($prop as $key => $value) {
                // dd($value);
                $prop_array[] = $key;
                if (strpos($value, ',')) {
                    $values = [];
                    $values = explode(",", $value);
                    
                    // dd($values);                    
                } else {
                    $values = [];
                    $values = $value;
                }
                // $new_array[] = $key;
                $new_array[$key] = $values;
            }
            // dd($new_array);
            // dd($prop);
            // 

            $products_array = Propertyvalue::whereIn('property_id', $prop_array)->pluck('id');
            // dd($products_array);
            $prop_array = Propertyvalue::whereIn('property_id', $prop_array)->pluck('product_id');
            // dd($prop_array);
            
            // dd($products);
            // $props = Propertyvalue::wherein('products', $products)->get();
            // dd($props);
            
        } else {
            $new_array = [];
        }  
        // dd($products);      

        // выбираем все propertyvalues и кидаем в массив айдишники товаров
        // выбираем товары с параметром wherein (id товаров из массива)
        //

        $products_array = $products->pluck('id');
        $property_values = Propertyvalue::whereIn('product_id', $products_array)->with('properties')->get();
        

        // $unique_property_values = $property_values->map(function ($property_values) {
        //     return collect($property_values)->unique('value')->all();
        // });

        $unique_property_values = $property_values->pluck('value')->unique();

        $properties = $property_values->whereIn('value', $unique_property_values)->unique('value');


        // dd($products_array, $property_values, $unique_property_values, $properties);
        $data = array (
            'products' => $products,
            'category' => $category,
            'properties' => $properties,
            'checked_properties' => $new_array,
            // 'subcategories' => Category::where('slug', $slug)->firstOrFail()
        );
        // dd($data['properties']);
        return view('category', $data);
    }

    public function categories() {
        $hour = 60;
        $categories = Cache::remember('categories', $hour, function() {
            return Category::orderBy('category', 'ASC')->where('category_id', 0)->get();
        });
        $data = array (
            'categories' => $categories,
            // 'subcategories' => Category::where('slug', $slug)->firstOrFail()
        );
        // dd($data['products']);
        return view('categories', $data);
    }

    public function articles() {
        $data = array (
            'articles' => Article::orderBy('id', 'DESC')->paginate(20),
        );
        return view('articles', $data);
    }

    public function article($slug) {
        $data = array (
            'article' => Article::with('products')->where('slug', $slug)->first(),
        );
        return view('article', $data);
    }

    public function sales() {
        $today = Carbon::now()->toDateString();
        $data = array (
            // 'sales' => Discount::orderBy('discount_end', 'ASC')->where('discount_end', '>=', $today)->get(),
            'sales' => Discount::orderBy('discount_end', 'DESC')->get(),
        );
        return view('sales', $data);
    }

    public function sale($slug) {
        $sale = Discount::where('slug', $slug)->FirstOrFail();
        if(isset($sale)) {
            $sale->increment('views', 1);
        }
        $data = array (
            'sale' => $sale,
        );
        return view('sale', $data);
    }

    public function manufactures() {
        $manufactures = Manufacture::all();
        $data = array (
            'manufactures' => $manufactures,
        );
        return view('manufactures', $data);
    }

    public function manufacture($slug) {
        // dd($slug);
        $manufacture = Manufacture::where('slug', $slug)->firstOrFail();
        // dd($category);
        $data = array (
            'products' => Product::orderBy('id', 'DESC')->where('manufacture_id', $manufacture->id)->get(),
            'manufacture' => $manufacture,
        );
        // dd($data['products']);
        return view('manufacture', $data);
    }

    public function product($category_slug = NULL, $slug) {
        $product = Product::where('slug', $slug)->firstOrFail();
        if (isset($category_slug)) {
            // $id = Product::where('slug', $slug)->pluck('category_id')->first();
            $properties = $product->category->property;
            $propertyvalues = Propertyvalue::where('product_id', $product->id)->pluck('value', 'property_id');
        } else {
            $properties = array();
            $propertyvalues = array();
        }
        // dd($propertyvalues);

        $data = array (
            'product' => Product::where('slug', $slug)->firstOrFail(),
            'propertyvalues' => $propertyvalues,
        );
        // dd($data['product']->images);
        return view('product', $data);
    }

    public function product2($slug) {
        $product = Product::where('slug', $slug)->firstOrFail();
        if (isset($category_slug)) {
            // $id = Product::where('slug', $slug)->pluck('category_id')->first();
            $properties = $product->category->property;
            $propertyvalues = Propertyvalue::where('product_id', $product->id)->pluck('value', 'property_id');
        } else {
            $properties = array();
            $propertyvalues = array();
        }

        $data = array (
            'product' => Product::where('slug', $slug)->firstOrFail(),
            'propertyvalues' => $propertyvalues,
        );
        // dd($data['product']->images);
        return view('product', $data);
    }
    
    public function sets() {
        $set = Set::get();
        $data = array (
            'sets' => $set,
        );
        // dd($set);
        return view('sets', $data);
    }

    public function set($slug) {
        $set = Set::where('slug', $slug)->firstOrFail();
        $data = array (
            // 'products' => Product::orderBy('id', 'DESC')->where('set_id', $set->id)->get(),
            'set' => $set,
        );
        // dd($set);
        return view('set', $data);
    }
}
