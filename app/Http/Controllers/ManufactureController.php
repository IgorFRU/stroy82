<?php

namespace App\Http\Controllers;

use App\Manufacture;
use Illuminate\Http\Request;

class ManufactureController extends Controller
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
            'title' => 'Производители',
            'manufactures' => Manufacture::orderBy('id', 'DESC')->get(),
        );
        return view('admin.manufactures.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'title' => 'Новый производитель',
            'manufacture' => [],
        );
        // dd($data['categories']);
        
        return view('admin.manufactures.create', $data);
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
        $manufacture = Manufacture::create($request->all());
        
        return redirect()->route('admin.manufactures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Manufacture  $manufacture
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacture $manufacture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Manufacture  $manufacture
     * @return \Illuminate\Http\Response
     */
    public function edit(Manufacture $manufacture)
    {
        $data = array (
            'title' => 'Редактирование производителя',
            'manufacture' => $manufacture
        );
        
        return view('admin.manufactures.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Manufacture  $manufacture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacture $manufacture)
    {
        $manufacture->update($request->except('alias'));

        return redirect()->route('admin.manufactures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Manufacture  $manufacture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacture $manufacture)
    {
        if ($manufacture->image) {
            unlink(public_path('imgs/manufactures/'.$manufacture->image));
        }        
        $manufacture->delete();
        return redirect()->route('admin.manufactures.index');
    }
}
