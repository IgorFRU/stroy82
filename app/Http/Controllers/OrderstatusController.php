<?php

namespace App\Http\Controllers;

use App\Orderstatus;
use Illuminate\Http\Request;

class OrderstatusController extends Controller
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
            'orderstatuses' => Orderstatus::orderBy('id', 'ASC')->get(),
        );
        return view('admin.orderstatuses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'orderstatus' => [],
        );
        
        return view('admin.orderstatuses.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderstatus = Orderstatus::create($request->all());        
        return redirect()->route('admin.orderstatuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orderstatus  $orderstatus
     * @return \Illuminate\Http\Response
     */
    public function show(Orderstatus $orderstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orderstatus  $orderstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(Orderstatus $orderstatus)
    {
        $data = array (
            'orderstatus' => $orderstatus
        );
        
        return view('admin.orderstatuses.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orderstatus  $orderstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orderstatus $orderstatus)
    {
        $orderstatus->update($request->all());

        return redirect()->route('admin.orderstatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orderstatus  $orderstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orderstatus $orderstatus)
    {
        $orderstatus->delete();
        return redirect()->route('admin.orderstatuses.index');
    }
}
