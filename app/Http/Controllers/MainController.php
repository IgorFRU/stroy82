<?php

namespace App\Http\Controllers;

use App\Article;
use App\Discount;
use App\Banner;
use App\Product;
use App\Property;
use App\Propertyvalue;
use App\Manufacture;
use App\Category;
use App\Set;
use App\Setting;
use App\Topmenu;
use Carbon\Carbon;

use Captcha;

use Illuminate\Http\Request;
use App\Mail\QuestionMail;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

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
            $discounts = Discount::orderBy('discount_end', 'ASC')->whereIn('id', $discount_ids)->actuality();
        } else {
            $discounts = null;
        }
        $hour = 60;
        $categories = Cache::remember('categories', $hour, function() {
            return Category::orderBy('category', 'ASC')->where('category_id', 0)->get();
        });
        // dd($discounts);
        $data = array (
            'banners' => Banner::published()->get(),
            'articles' => Article::orderBy('id', 'DESC')->limit(4)->get(),
            'discounts' => $discounts,
            'lastProducts' => Product::published()->orderBy('id', 'DESC')->limit(4)->get(),
            'popularProducts' => Product::published()->popular('4')->get(),
            'about' => Setting::first(),
            'categories' => $categories,
        );
        // dd($data['popularProducts']);
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

        $filterManufacture = [];
        $filter = 0;
        $hour = 60;

        $itemsPerPage = (isset($_COOKIE['products_per_page'])) ? $itemsPerPage = $_COOKIE['products_per_page'] : $itemsPerPage = 48;

        $category = Category::where('slug', $slug)->with('property')->firstOrFail();
        if(isset($category)) {
            $category->increment('views', 1);
        }
        $products = Product::where('category_id', $category->id)->published()->order()->with('category')->with('manufacture')->paginate($itemsPerPage);
        $manufactures = Manufacture::whereIn('id', $products->pluck('manufacture_id'))->get();
        
        if ($request->all() != NULL) {
            foreach ($request->all() as $key => $value) {
                if ($key == 'manufacture') {
                    $filterManufacture = explode(",", $value);
                }

            }
        }

        // dd($request->all());
        // dd($filterManufacture);
       

        
        

        // $products = Product::
        // when($category, function ($query, $category) {
        //     return $query->where('category_id', $category);
        // })
        // ->when($manufacture, function ($query, $manufacture) {
        //     return $query->where('manufacture_id', $manufacture);
        // })->orderBy('id', 'desc')->with('category')->whereIn('published', $published)->with('manufacture')->paginate($itemsPerPage);


        

        
        $categories = Cache::remember('categories', $hour, function() {
            return Category::orderBy('category', 'ASC')->where('category_id', 0)->with('children')->get();
        });
        // $products = Product::orderBy('id', 'DESC')->where('category_id', $category->id)->get();
        
        
       
        
        if (count($filterManufacture) > 0) {
            $products_filtered = $products->whereIn('manufacture_id', $filterManufacture);
        } else {
            $products_filtered = $products;
        }


        if ($filter) {

            $prop_products_array = [];
            $prop_array = [];

            $new_array = [];
            foreach ($filter as $key => $value) {
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
            // dd($filt);
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

        $local_title = $category->category;
        // dd($products_array, $property_values, $unique_property_values, $properties);
        $data = array (
            'products' => $products,
            'products_filtered' => $products_filtered,
            'category' => $category,
            'categories' => $categories,
            'properties' => $properties,
            'checked_properties' => $new_array,
            'local_title' => $local_title,
            'manufactures' => $manufactures,
            'filteredManufacture' => $filterManufacture
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
            'local_title' => 'Категории товаров',
            // 'subcategories' => Category::where('slug', $slug)->firstOrFail()
        );
        // dd($data['products']);
        return view('categories', $data);
    }

    public function articles() {
        $data = array (
            'articles' => Article::orderBy('id', 'DESC')->paginate(20),
            'local_title' => 'Статьи',
        );
        return view('articles', $data);
    }

    public function article($slug) {
        $article = Article::with('products')->where('slug', $slug)->FirstOrFail();
        $local_title = $article->article;
        $data = array (
            'article' => $article,
            'local_title' => $local_title,
        );
        return view('article', $data);
    }

    public function sales() {
        $today = Carbon::now()->toDateString();
        $data = array (
            // 'sales' => Discount::orderBy('discount_end', 'ASC')->where('discount_end', '>=', $today)->get(),
            'sales' => Discount::orderBy('discount_end', 'DESC')->get(),
            'local_title' => 'Акции',
        );
        return view('sales', $data);
    }

    public function sale($slug) {
        $sale = Discount::where('slug', $slug)->FirstOrFail();
        if(isset($sale)) {
            $sale->increment('views', 1);
        }
        $local_title = $sale->discount . ' ' . $sale->value . $sale->rus_type;
        $data = array (
            'sale' => $sale,
            'local_title' => $local_title,
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
        if(isset($product)) {
            $product->increment('views', 1);
        }
        if (isset($category_slug)) {
            // $id = Product::where('slug', $slug)->pluck('category_id')->first();
            $properties = $product->category->property;
            $propertyvalues = Propertyvalue::where('product_id', $product->id)->pluck('value', 'property_id');
        } else {
            $properties = array();
            $propertyvalues = array();
        }
        // dd($propertyvalues);

        $local_title = $product->product . ' - ' . $product->category->category;
        $data = array (
            'product' => $product,
            'propertyvalues' => $propertyvalues,
            'local_title' => $local_title,
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

    public function contacts()
    {
        $contacts = Setting::firstOrFail();

        $data = [
            'contacts' => $contacts,
            'captcha' => Captcha::create(),
        ];

        return view('contacts', $data);
    }

    public function sendQuestion(Request $request) {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            return redirect('contacts')->with('error', 'Ваше письмо не было отправлено! Проверьте правильность заполнения полей и повторите попытку. Если ошибка повторится, свяжитесь, пожалуйста, с нами по телефону. Приносим свои извинения за временные неудобства.');
        } else {
            $mail_body = '
            <html>
                <body>
                    <p>Имя: '.$request->name.'</p>
                    <p>Телефон: '.$request->phone.'</p>                        
                    <p>Товар: '.$request->question.'</p>                      
                </body>
            </html>';
            $toEmail = "igor.parketmir@gmail.com";
            Mail::to($toEmail)->send(new QuestionMail($mail_body));
            return redirect('contacts')->with('success', 'Ваше письмо успешно отправлено! Мы свяжемся с вами в ближайшее время.');
        }
    }

    public function setCookie(Request $request) {
        if (isset($request->product_sort) && $request->product_sort != '') {
            setcookie('product_sort', $request->product_sort, time()+60*60*24*365);
        }
        if (isset($request->products_per_page) && $request->products_per_page != '') {
            setcookie('products_per_page', $request->products_per_page, time()+60*60*24*365); 
        }
        if (isset($request->scroll) && $request->scroll != '') {
            setcookie('scroll', $request->scroll, time()+60); 
        }
    }
    

    public function comingsoon () {
        return view('comingsoon');
    }
}
