<?php

namespace App\Http\Controllers;

use App\Category;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
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
            'title' => 'Категории товаров',
            'categories' => Category::orderBy('id', 'DESC')
                                    ->paginate(20)
        );

        return view('admin.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'title' => 'Новая категория',
            'category' => [],
            //коллекция вложенных подкатегорий
            'categories' => Category::with('children')->where('category_id', '0')->with('property')->get(),
            'properties' => Property::orderBy('property', 'asc')->get(),
            //символ, обозначающий вложенность категорий
            'delimiter' => ''
        );
        // dd($data['categories']);
        
        return view('admin.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($request->all());
        
        if (isset($request->property_id) && $request->property_id != 0) {
            $properties = Arr::sort($request->property_id);
            $category->property()->sync($properties, true);
        }

        Cache::forget('categories');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно добавлена.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $property_ids = $category->property->pluck('id');
        $data = array (
            'title' => 'Редактирование категории',
            'category' => $category,
            'categories' => Category::with('children')->where('category_id', '0')->with('property')->get(),
            'properties' => Property::whereNotIn('id', $property_ids)->orderBy('property', 'asc')->get(),
            'delimiter' => ''
        );
        return view('admin.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // dd($request->all());
        $category->update($request->except('alias'));
        if (isset($request->property_id) && $request->property_id != 0) {
            $properties = Arr::sort($request->property_id);
            $category->property()->sync($properties, true);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно Изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path('imgs/categories/'. $category->image))) {
            unlink(public_path('imgs/categories/'.$category->image));
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно удалена');
    }
}
