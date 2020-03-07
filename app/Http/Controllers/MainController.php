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

        $local_title = $category->category . ' купить по хорошей цене в строительном интернет-магазине Крыма Stroy82.com';
        // dd($products_array, $property_values, $unique_property_values, $properties);

        if ($category->meta_description) {
            $description = $category->meta_description . '. ' . $category->category;
        } else {
            $description = 'Продажа строительных товаров категории ' . $category->category . ' с доставкой по Крыму и Симферополю по лучшей цене';
        }
        
        $data = array (
            'products'              => $products,
            'products_filtered'     => $products_filtered,
            'category'              => $category,
            'categories'            => $categories,
            'properties'            => $properties,
            'checked_properties'    => $new_array,
            'local_title'           => $local_title,
            'manufactures'          => $manufactures,
            'filteredManufacture'   => $filterManufacture,
            'description'           => $description,
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
            'categories'    => $categories,
            'local_title'   => 'Купить строительные товары и материалы дешево с доставкой по Симферополю и Крыму',
            'description'   => 'Категории товаров в строительном магазине Stroy82.com. Низкие цены, доставка по Симферополю и Крыму',
        );
        
        return view('categories', $data);
    }

    public function articles() {
        $data = array (
            'articles'      => Article::orderBy('id', 'DESC')->paginate(20),
            'local_title'   => 'Статьи о строительных материалах и технологиях в строительном интернет-магазине Крыма Stroy82.com',
            'description'   => 'Подробное изучение тонкостей ремонта, подбора строительных и отделочных материалов, советы по ремонту от профессионального строительного интернет-магазина Stroy82.com',
        );
        return view('articles', $data);
    }

    public function article($slug) {
        $article = Article::with('products')->where('slug', $slug)->FirstOrFail();
        $local_title = $article->article . ' - статья в строительном интернет-магазине Stroy82.com';
        if ($article->decription) {
            $description = $article->limit_text;
        } else {
            $description = 'Полезная статья в строительно интернет-магазине Stroy82.com';
        }
        
        $data = array (
            'article' => $article,
            'local_title' => $local_title,
            'description' => $description,
        );
        return view('article', $data);
    }

    public function sales() {
        $today = Carbon::now()->toDateString();
        $data = array (
            // 'sales' => Discount::orderBy('discount_end', 'ASC')->where('discount_end', '>=', $today)->get(),
            'sales' => Discount::orderBy('discount_end', 'DESC')->get(),
            'local_title' => 'Акции, скидки и лучшие ценовые предложения в строительном магазине Stroy82.com. Доставка по Симферополю и Крыму',
            'description'   => 'Акционные предложения с выгодными покупками строительных и отделочных материалов дешево в Симферополе - строительный интернет-магазин Stroy82.com',
        );
        return view('sales', $data);
    }

    public function sale($slug) {
        $sale = Discount::where('slug', $slug)->FirstOrFail();
        if(isset($sale)) {
            $sale->increment('views', 1);
        }
        $local_title = $sale->discount . ' ' . $sale->value . $sale->rus_type;
        if ($sale->decription) {
            $description = $sale->description;
        } else {
            $description = 'Скидка на строительные товары в строительном интернет-магазине Stroy82.com';
        }
        $data = array (
            'sale' => $sale,
            'local_title' => $local_title,
            'description' => $description,
        );
        return view('sale', $data);
    }

    public function manufactures() {
        $manufactures = Manufacture::all();
        $data = array (
            'manufactures' => $manufactures,
            'local_title' => 'Производители строительных и отделочных материалов, представленных в строительном магазине Stroy82.com',
            'description'   => 'Продажа по низким ценам строительных и отделочных материалов в Симферополе от лучших Российских и мировых производителей',
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
            'local_title' => 'Производитель ' . $manufacture->manufacture . '. Товары из всех категорий в строительном магазине Stroy82.com. Продажа и доставка в Симферополе и Крыму',
            'description'   => 'Продажа по низким ценам строительных и отделочных материалов в Симферополе изготовителя ' . $manufacture->manufacture,
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
        if ($product->meta_description) {
            $description = $product->meta_description;
        } elseif($product->description) {
            $description = $product->clear_description;
        } else {
            $description = 'Купить в Симферополе ' . $product->product . ' по лучшей цене с доставкой';
        }
        
        $local_title = $product->product . ' - ' . $product->category->category . '. Цена. Купить дешево в Крыму и Симферополе с доставкой';
        $data = array (
            'product' => $product,
            'propertyvalues' => $propertyvalues,
            'local_title' => $local_title,
            'description' => $description,
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
        
        if ($product->meta_description) {
            $description = $product->meta_description;
        } elseif($product->description) {
            $description = $product->description;
        } else {
            $description = 'Купить в Симферополе ' . $product->product . ' по лучшей цене с доставкой';
        }

        $local_title = $product->product . '. Цена. Купить дешево в Крыму и Симферополе с доставкой';

        $data = array (
            'product' => Product::where('slug', $slug)->firstOrFail(),
            'propertyvalues' => $propertyvalues,
            'local_title' => $local_title,
            'description' => $description,
        );
        // dd($data['product']->images);
        return view('product', $data);
    }
    
    public function sets() {
        $set = Set::get();
        $data = array (
            'sets' => $set,
            'local_title' => 'Группы строительных товаров по сфере применения и решению задач. Удобная группировка необходимых строительных товаров в одном месте.',
            'description' => 'Грамотная группировка строительных и отделочных материалов по низкой цене. Все необходимые материалы для тех или иных работ в одном месте',
        );
        // dd($set);
        return view('sets', $data);
    }

    public function set($slug) {
        $set = Set::where('slug', $slug)->firstOrFail();

        if ($set->meta_description) {
            $description = $set->meta_description;
        } elseif($set->description) {
            $description = $set->description;
        } else {
            $description = 'Купить в Симферополе материалы для ' . $set->set . ' по лучшей цене с доставкой';
        }

        $local_title = $set->set . '. Цена. Группа товаров. Купить дешево в Крыму и Симферополе с доставкой';

        $data = array (
            // 'products' => Product::orderBy('id', 'DESC')->where('set_id', $set->id)->get(),
            'set'           => $set,
            'local_title'   => $local_title,
            'description'   => $description,
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
            'local_title' => 'Контакты строительного интернет-магазина Stroy82.com',
            'description' => 'Профессиональный интернет-магазин строительных и отделочных товаров в Симферополе. Контакты магазина, в котором можно дешево купить всё для строительства и ремонта',
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
            if (Setting::first()->email) {
                $toEmail = Setting::first()->email;
            } else {
                $toEmail = App\Admin::first()->email;
            }            
            
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
