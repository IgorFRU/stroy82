<?php

namespace App\Http\Controllers;

use App\Topmenu;

use Illuminate\Http\Request;

class TopmenuController extends Controller
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
            'topmenus' => Topmenu::orderBy('title', 'ASC')->get(),
        );
        return view('admin.topmenu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'topmenu' => [],
        );
        
        return view('admin.topmenu.create', $data);
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
        $topmenu = Topmenu::create($request->all());        
        return redirect()->route('admin.topmenu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topmenu  $topmenu
     * @return \Illuminate\Http\Response
     */
    public function show(Topmenu $topmenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topmenu  $topmenu
     * @return \Illuminate\Http\Response
     */
    public function edit(Topmenu $topmenu)
    {
        $data = array (
            'topmenu' => $topmenu
        );
        
        return view('admin.topmenu.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topmenu  $topmenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topmenu $topmenu)
    {
        // dd($request->all());
        $topmenu->update($request->all());

        return redirect()->route('admin.topmenu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topmenu  $topmenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topmenu $topmenu)
    {
        
    }
}
