<?php

namespace App\Http\Controllers;

use App\Typeoption;
use Illuminate\Http\Request;

class TypeoptionController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Typeoption  $typeoption
     * @return \Illuminate\Http\Response
     */
    public function show(Typeoption $typeoption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Typeoption  $typeoption
     * @return \Illuminate\Http\Response
     */
    public function edit(Typeoption $typeoption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Typeoption  $typeoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typeoption $typeoption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Typeoption  $typeoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Typeoption $typeoption)
    {
        //
    }
}
