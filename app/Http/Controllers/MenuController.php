<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
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
            'title'         => 'АДМИН - Паркетный мир - Пункты меню',
            'menus'    => Menu::orderBy('sortpriority', 'ASC')->orderBy('menu', 'ASC')->get(),
        );

        return view('admin.menus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (            
            'title'       => 'АДМИН - Паркетный мир - Добавление пункта меню',
            'menu'     => [],
        ); 
        // dd($data['categories']);
        return view('admin.menus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Menu::create($request->all());
        
        return redirect()->route('admin.menus.index')->with('success', 'Пункт меню успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $data = array (            
            'menu' => $menu
        );
        
        return view('admin.menus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'menu' => 'required|max:63',
        ]);
        
        $menu->update($request->all());

        return redirect()->route('admin.menus.index')->with('success', 'Пункт меню успешно изменён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        // $menu = Menu::find($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Пункт меню успешно удалён');
    }
}
