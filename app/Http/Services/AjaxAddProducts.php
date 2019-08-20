<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AjaxAddProducts
{
    public function addProducts(Request $request) {

        $jsonProducts = $request->products;
        $jsonArticle = Str::after($request->article, 'article_id=');
        $jsonProducts = explode("&", $jsonProducts);
        $jsonProducts = array_unique($jsonProducts);

        $article = Article::where('id', $jsonArticle)->first();

        foreach ($jsonProducts as $key => $product) {
            $products[] = Str::after($product, 'product_id=');

            // $article->products()->attach($products[$key]);
        }

        $products = Arr::sort($products);
        

        foreach ($products as $key => $product) {
            $article->products()->attach($product);
        }        
        $products['collection'] = Product::whereIn('id', $products)->get();
        $products['article'] = $jsonArticle;

        echo json_encode($products);
    }
} 