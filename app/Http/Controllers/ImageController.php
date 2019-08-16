<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;

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
        

        if ($request->path == 'product') {
            $path = public_path().'\imgs\products\\';
            if (!file_exists($path)) {
                mkdir($path, 0777);
            }
            $path_thumbnail = public_path().'\imgs\products\thumbnails\\';
            if (!file_exists($path_thumbnail)) {
                mkdir($path_thumbnail, 0777);
            }
        } else {
            $path = public_path().'\imgs\media\\';
            if (!file_exists($path)) {
                mkdir($path, 0777);
            }
            $path_thumbnail = public_path().'\imgs\media\thumbnails\\';
            if (!file_exists($path_thumbnail)) {
                mkdir($path_thumbnail, 0777);
            }
        }  

        if (isset($request->product_id)) {
            $productname = isset($request->product_id);
            $filename = '';
            $filename_thumbnail = '';
        } else {
            $productname = '';
            $filename = '-noprod-';
            $filename_thumbnail = '-noprod-';
        }

        if (isset($request->method) && $request->method == 'store') {
            $file = $request->image;
            $base_name = str_random(20);
            $filename .= $base_name .'.' . $file->getClientOriginalExtension() ?: 'png';
            $filename_thumbnail .= $base_name .'_thumbnail.' . $file->getClientOriginalExtension() ?: 'png';
            $img = ImageManagerStatic::make($file);
            $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($path . $filename);
            $thumbnail = $img->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($path_thumbnail . $filename_thumbnail);

            if($request->main && isset($request->product_id)) {      
                $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
                                                            ->pluck('image_id'))
                                ->where('main', 1)
                                ->get();
                foreach ($imgs as $img) {
                    $img->main = 0;
                    $img->save();
                }            
            }

            if (isset($request->main)) {
                $main = $request->main;
            } else {
                $main = 0;
            }
            

            $image = Image::create([
                'image' => $filename, 
                'name' => $request->name,
                'productname' => $productname,
                'alt' => $request->alt,
                'thumbnail' => $filename_thumbnail,
                'main' => $request->main
            ]);    
            
            echo json_encode($image);
        }

        if (isset($request->method) && $request->method == 'update') {
            
            $image = Image::where('id', $request->id)->first();
            $image->name = $request->name;
            $image->alt = $request->alt;
            $image->update();

            echo json_encode($image);
        }

        if (isset($request->method) && $request->method == 'delete') {
            $image = Image::where('id', $request->image_id)->first();

            if ($image->image && file_exists(public_path('imgs/products/'. $image->image))) {
                unlink(public_path('imgs/products/'.$image->image));
            }
            if ($image->thumbnail && file_exists(public_path('imgs/products/thumbnails/'. $image->thumbnail))) {
                unlink(public_path('imgs/products/thumbnails/'.$image->thumbnail));
            }
            $image->delete();
            echo json_encode(array('id' => $request->image_id));
        }
        
        

        // $image->products()->attach($request->product_id);

        // $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
                            //                             ->pluck('image_id'))
                            // ->where('main', 1)
                            // ->pluck('id');
        //dd($imgs);
        // if (count($imgs) == 0) {
        //     $mainimg = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
        //                                                 ->pluck('image_id'))
        //                     ->get();
        //     $mainimg[0]->main = 1;
        //     $mainimg[0]->save();
        // }
        // return redirect()->back()->with('addImages', 'true');
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
        $image = Image::where('id', $request->id)->first();
        $image->name = $request->name;
        $image->alt = $request->alt;
        $image->update();

        echo json_encode($image);
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
