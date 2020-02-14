<?php

namespace App\Http\Controllers;

use App\Set;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SetController extends Controller
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
            'title' => 'Группы товаров',
            'sets' => Set::orderBy('id', 'DESC')->get()
        );

        return view('admin.sets.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'title' => 'Новая группа товаров',
            'set' => [],
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'delimiter' => ''
        );
        
        return view('admin.sets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'set' => 'required|min:3|max:191',
        ]);
        $set = Set::create($request->except('product_id'));
        $products = Arr::sort($request->product_id);
        $set->products()->sync($products, true);

        return redirect()->route('admin.sets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function show(Set $set)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function edit(Set $set)
    {
        $data = array (
            'title' => 'Изменение группы товаров',
            'set' => $set,
            'categories' => Category::with('children')->where('category_id', '0')->get(),
            'delimiter' => ''
        );
        
        return view('admin.sets.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Set $set)
    {
        $validatedData = $request->validate([
            'set' => 'required|min:3|max:191',
        ]);
        $set->update($request->except('alias', 'product_id'));
        $products = Arr::sort($request->product_id);
        $set->products()->sync($products, true);

        return redirect()->route('admin.sets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set)
    {
        if (file_exists(public_path('imgs/sets/'. $set->image))) {
            try {
                $file = new Filesystem;
                $file->delete(public_path('imgs/sets/'. $set->image));
            } catch (\Throwable $th) {
                echo 'Сообщение: '   . $th->getMessage() . '<br />';
            }                
        }
        $set->delete();

        return redirect()->route('admin.sets.index');
    }

    // public function addProducts(Request $request) {
    //     // dd($request->all());

    //     // $json = array();

    //     $jsonProducts = $request->products;
    //     $jsonSet = Str::after($request->set, 'set_id=');
    //     $jsonProducts = explode("&", $jsonProducts);
    //     $jsonProducts = array_unique($jsonProducts);

    //     $article = Set::where('id', $jsonSet)->first();

    //     foreach ($jsonProducts as $key => $product) {
    //         $products[] = Str::after($product, 'product_id=');

    //         // $article->products()->attach($products[$key]);
    //     }

    //     $products = Arr::sort($products);
        

    //     foreach ($products as $key => $product) {
    //         $article->products()->attach($product);
    //     }        
    //     $products['collection'] = Product::whereIn('id', $products)->get();
    //     $products['article'] = $jsonSet;

    //     echo json_encode($products);
    // }
}
