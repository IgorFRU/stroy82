<?php

namespace App\Http\Controllers;

use App\Article;
use App\Discount;
use App\Product;
use Carbon\Carbon;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $today = Carbon::now();
        $discount_ids = array();
        $discount_not_ids = array();
        // $discounts = Discount::where('discount_end', '>=', $today)->orderBy('discount_end', 'ASC')->limit(1)->pluck('id');
        $discount_products = Discount::orderBy('discount_end', 'ASC')->actuality->first();
dd($discount_products);
        // $priced = $discount_products->priced_products->where('published', 1);
        // dd($priced->count());
        // dd($discount_products->priced_products->where('published', 1)->count());

        while ($discount_products->priced_products->where('published', 1)->count() < 3) {
            if ($discount_products->priced_products->where('published', 1)->count() == 0) {
                $discount_not_ids[] = $discount_products->id;
            }
            $discount_ids[] = $discount_products->id;
            $discount_products = Discount::whereNotIn('id', $discount_ids)->where('discount_end', '>=', $today)->orderBy('discount_end', 'ASC')->first();
            if (!isset($discount_products)) {
                break;
            }
        }
        // dd(count($discount_not_ids));
        if (count($discount_ids) > 0) {
            $discounts = Discount::when(count($discount_not_ids) > 0, function ($query, $discount_not_ids) {
                return $query->whereNotIn('id', $discount_not_ids);
            })->whereIn('id', $discount_ids)->where(function ($query) {
                $query->where('discount_end', '>=', $today);
            })->orderBy('discount_end', 'ASC')->get();
        } else {
            $discounts = Discount::when(count($discount_not_ids) > 0, function ($query, $discount_not_ids) {
                return $query->whereNotIn('id', $discount_not_ids);
            })->where('discount_end', '>=', $today)->orderBy('discount_end', 'ASC')->get();
        }
        
        // dd($discount_ids);
        $data = array (
            'articles' => Article::orderBy('id', 'DESC')->limit(4)->get(),
            'discounts' => $discounts,
        );
        dd($data['discounts']);
        // dd($discount_products->last_products);
        return view('welcome', $data);
    }
}
