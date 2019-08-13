<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ArticleController extends Controller
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
    public function index()
    {
        $data = array (
            'articles' => Article::orderBy('id', 'DESC')->get()
        );

        return view('admin.articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'article' => []
        );
        
        return view('admin.articles.create', $data);
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
        $article = Article::create($request->all());
        
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $data = array (
            'article' => $article,
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'delimiter' => ''
        );
        
        return view('admin.articles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->except('alias'));

        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (file_exists(public_path('imgs/articles/'. $article->image))) {
            try {
                $file = new Filesystem;
                $file->delete(public_path('imgs/articles/'. $article->image));
            } catch (\Throwable $th) {
                echo 'Сообщение: '   . $th->getMessage() . '<br />';
            }                
        }
        // unlink(public_path('imgs/articles/'.$article->image));
        $article->delete();

        return redirect()->route('admin.articles.index');
    }

    public function addProducts(Request $request) {
        // dd($request->all());

        // $json = array();

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

        

        echo json_encode($products);
    }
}
