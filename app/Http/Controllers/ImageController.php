<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
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
        
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo json_encode($request->image);

        // if ($request->path == 'product') {
        //     $path = public_path().'\imgs\products\\';
        //     if (!file_exists($path)) {
        //         mkdir($path, 0777);
        //     }
        //     $path_thumbnail = public_path().'\imgs\products\thumbnails\\';
        //     if (!file_exists($path_thumbnail)) {
        //         mkdir($path_thumbnail, 0777);
        //     }
        // } else {
        //     $path = public_path().'\imgs\media\\';
        //     if (!file_exists($path)) {
        //         mkdir($path, 0777);
        //     }
        //     $path_thumbnail = public_path().'\imgs\media\thumbnails\\';
        //     if (!file_exists($path_thumbnail)) {
        //         mkdir($path_thumbnail, 0777);
        //     }
        // }
        
        // $file = $request->file('image');

        // $base_name = str_random(20);
        // $productname = Str::slug(mb_substr($request->product, 0, 60), "-");

        // $filename = $base_name .'.' . $file->getClientOriginalExtension() ?: 'png';
        // $filename_thumbnail = $base_name .'_thumbnail.' . $file->getClientOriginalExtension() ?: 'png';
        // $img = ImageManagerStatic::make($file);
        // $img->resize(600, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })
        //     ->save($path . $filename);
        // $thumbnail = $img->resize(250, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })
        //     ->save($path_thumbnail . $filename_thumbnail);

        // if($request->main) {      
        //     $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
        //                                                 ->pluck('image_id'))
        //                     ->where('main', 1)
        //                     ->get();
        //     foreach ($imgs as $img) {
        //         $img->main = 0;
        //         $img->save();
        //     }            
        // }

        // $image = Image::create([
        //     'image' => $filename, 
        //     'name' => $request->name,
        //     'productname' => $productname,
        //     'alt' => $request->alt,
        //     'thumbnail' => $filename_thumbnail,
        //     'main' => $request->main
        //     ]);      
        
        // $image->products()->attach($request->product_id);

        // $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
        //                                                 ->pluck('image_id'))
        //                     ->where('main', 1)
        //                     ->pluck('id');
        // //dd($imgs);
        // if (count($imgs) == 0) {
        //     $mainimg = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
        //                                                 ->pluck('image_id'))
        //                     ->get();
        //     $mainimg[0]->main = 1;
        //     $mainimg[0]->save();
        // }
        // // return redirect()->back()->with('addImages', 'true');
        // return redirect()->route('admin.products.addImages', $request->product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
