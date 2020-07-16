<?php

namespace App\Http\Controllers;

use App\Bannertag;
use Illuminate\Http\Request;

class BannertagController extends Controller
{
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
        $banner_tag = Bannertag::create($request->all());
        return $banner_tag;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bannertag  $bannertag
     * @return \Illuminate\Http\Response
     */
    public function show(Bannertag $bannertag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bannertag  $bannertag
     * @return \Illuminate\Http\Response
     */
    public function edit(Bannertag $bannertag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bannertag  $bannertag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bannertag $bannertag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bannertag  $bannertag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bannertag $bannertag)
    {
        //
    }
}
