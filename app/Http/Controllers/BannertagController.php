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
        if ($request->id) {
            $tag = Bannertag::where('id', $request->id)->first();
            $tag->update($request->except('id'));
            return $tag;
        } else {
            return 0;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bannertag  $bannertag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bannertag $bannertag, Request $request)
    {
        if ($request->id) {
            $tag = Bannertag::where('id', $request->id)->first();
            $tag->delete();
            return 1;
        } else {
            return 0;
        }
    }

    public function getTag(Request $request) {
        
        $tag = Bannertag::where('id', $request->id)->first();
        
        if ($tag) {
            return $tag;
        } else {
            return 0;
        }        
    }
}
