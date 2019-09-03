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

    public function category($slug) {
        // dd($slug);
        $category = Category::where('slug', $slug)->firstOrFail();
        // dd($category);
        $data = array (
            'products' => Product::orderBy('id', 'DESC')->where('category_id', $category->id)->get(),
            'category' => $category,
            // 'subcategories' => Category::where('slug', $slug)->firstOrFail()
        );
        // dd($data['products']);
        return view('category', $data);
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
