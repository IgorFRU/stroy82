<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Cart;
use App\Order;
use App\Category;
use App\Article;
use App\Banner;
use App\Set;
use App\Setting;
use App\Product;
use App\Manufacture;
use App\Topmenu;
use App\Http\Services\WorkWithImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); //NEW: Increase StringLength
        date_default_timezone_set('Europe/Moscow');

        self::globalData();
        self::adminGlobalData();


        Category::creating(function(Category $model){
            $model->slug = Str::slug(mb_substr($model->category, 0, 60) . "-", "-");
            $double = Category::where('slug', $model->slug)->first();
            if ($double) {
                $next_id = Category::select('id')->orderby('id', 'desc')->first()['id'];
                $model->slug .= '-' . ++$next_id;
            }

            if($model->image) {
                // dd($model);
                $path = public_path().'/imgs/categories/';
                $file = $model->image;
                $img = new WorkWithImage($file, $path);
                $model->image = $img->saveImage();
            }
        });

        Category::updating(function(Category $model) {
            if($model->image) {
                // dd($model->image);
                $old_image = Category::select('image')->find($model->id);
                // dd($old_image->image);
                if($model->image != $old_image->image) {

                    if (file_exists(public_path().'/imgs/categories/' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'/imgs/categories/' . $old_image->image);
                    }
                    $path = public_path().'/imgs/categories/';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }
                
            }
        });

        Banner::updating(function(Banner $model) {
            if($model->image) {
                // dd($model->image);
                $old_image = Banner::select('image')->find($model->id);
                if($model->image != $old_image->image) {

                    if (file_exists(public_path().'/imgs/banners/' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'/imgs/banners/' . $old_image->image);
                    }
                    $path = public_path().'/imgs/banners/';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }
                
            }
        });

        Article::creating(function(Article $model){
            if($model->image) {
                // dd($model);
                $path = public_path().'/imgs/articles/';
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                }
                $file = $model->image;
                $img = new WorkWithImage($file, $path);
                $model->image = $img->saveImage();
            }
        });

        Article::updating(function(Article $model) {
            if($model->image) {
                $old_image = Article::select('image')->find($model->id);
                if($model->image != $old_image->image) {
                    if (file_exists(public_path().'/imgs/articles/' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'/imgs/articles/' . $old_image->image);
                    }
                    $path = public_path().'/imgs/articles/';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }                
            }
        });

        
        Set::creating(function(Set $model){
            if($model->image) {
                // dd($model);
                $path = public_path().'/imgs/sets/';
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                }
                $file = $model->image;
                $img = new WorkWithImage($file, $path);
                $model->image = $img->saveImage();
            }
        });

        Set::updating(function(Set $model) {
            if($model->image) {
                $old_image = Set::select('image')->find($model->id);
                if($model->image != $old_image->image) {
                    if (file_exists(public_path().'/imgs/sets/' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'/imgs/sets/' . $old_image->image);
                    }
                    $path = public_path().'/imgs/sets/';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }                
            }
        });


        // Product::creating(function(Product $model){
        //     $model->slug = Str::slug(mb_substr($model->product, 0, 60), "-");
        //     if ($model->scu) {
        //         $model->slug .= $model->scu;
        //     }
        //     $double = Product::where('slug', $model->slug)->first();
        //     if ($double) {
        //         $next_id = Product::select('id')->orderby('id', 'desc')->first()['id'];
        //         $model->slug .= '-' . ++$next_id;
        //     }
        // });

        // Manufacture::creating(function(Manufacture $model){
        //     if($model->image) {
        //         // dd($model);
        //         $path = public_path().'\imgs\manufactures\\';
        //         $file = $model->image;
        //         $img = new WorkWithImage($file, $path);
        //         $model->image = $img->saveImage();
        //     }
        // });

        // Manufacture::updating(function(Manufacture $model) {
        //     if($model->image) {
        //         // dd($model->image);
        //         $old_image = Manufacture::select('image')->find($model->id);
        //         // dd($old_image->image);
        //         if($model->image != $old_image->image) {
        //             $file = new Filesystem;
        //             $file->delete(public_path().'\imgs\manufactures\\' . $old_image->image);
        //             $path = public_path().'\imgs\manufactures\\';
        //             $file = $model->image;
        //             $img = new WorkWithImage($file, $path);
        //             $model->image = $img->saveImage();
        //         }
                
        //     }
        // });
    }

    public function globalData()
    {
        View::composer('layouts.main-app', function ($view){

            $hour = 60;

            $categories = Cache::remember('categories', $hour, function() {
                return Category::orderBy('category', 'ASC')->where('category_id', 0)->get();
            });
            $sets = Cache::remember('sets', $hour, function() {
                return Set::orderBy('set', 'ASC')->get();
            });  

            $settings = Cache::remember('settings', $hour, function() {
                return Setting::find(1)->first();
            });
                       
            $topmenu = Topmenu::where('published', 1)
                ->OrderBy('priority', 'ASC')
                ->OrderBy('title', 'DESC')
                ->get();
            
            $carts = Cart::where('session_id', session('session_id'))->actually()->get();
            // dd(session('session_id'));
            $carts1 = $carts->pluck('quantity', 'product_id');
            $carts2 = $carts->pluck('product_id');
            // dd($carts2);
            $products = Product::whereIn('id', $carts2)->get();
            // dd($products);
            // $cart_products = array();
            // foreach ($carts as $key => $cart) {
            //     $cart_products[] = [
            //         'id' => 
            //     ];
            // }
            // $product = Product::where('id', $cart->product_id)->first();
        
        

            $data = array (
                'categories'      => $categories,
                'sets'        => $sets,
                'carts' => $carts1,
                'settings' =>$settings,
                'cart_products' => $products,
                'topmenu' => $topmenu,
            );
            
            $view->with($data);
        });
    }

    public function adminGlobalData() {
        View::composer('layouts.admin-app', function ($view){

            $data = [
                'active_orders_count' => Order::unread()->count(),
            ];

            $view->with($data);
        });
    }
}
