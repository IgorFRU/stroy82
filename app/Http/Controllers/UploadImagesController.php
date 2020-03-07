<?php

namespace App\Http\Controllers;

use App\Image;
use App\ImageProduct;
use App\Product;
use App\Category;
use App\Manufacture;
use App\Discount;
use App\Vendor;
use App\Unit;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UploadImagesController extends Controller
{
    public function product(Request $request)
    {
        // dd($request->all());
        $path = public_path().'/imgs/products/';
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
        $path_thumbnail = public_path().'/imgs/products/thumbnails/';
        if (!file_exists($path_thumbnail)) {
            mkdir($path_thumbnail, 0777);
        }
        $file = $request->file('image');

        $base_name = str_random(20);
        $productname = Str::slug(mb_substr($request->product, 0, 60), "-");

        $filename = $base_name .'.' . $file->getClientOriginalExtension() ?: 'png';
        $filename_thumbnail = $base_name .'_thumbnail.' . $file->getClientOriginalExtension() ?: 'png';
        $img = ImageManagerStatic::make($file);
        $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($path . $filename);
        $thumbnail = $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($path_thumbnail . $filename_thumbnail);

        if($request->main) {      
            $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
                                                        ->pluck('image_id'))
                            ->where('main', 1)
                            ->get();
            foreach ($imgs as $img) {
                $img->main = 0;
                $img->save();
            }            
        }

        $image = Image::create([
            'image' => $filename, 
            'name' => $request->name,
            'productname' => $productname,
            'alt' => $request->alt,
            'thumbnail' => $filename_thumbnail,
            'main' => $request->main
            ]);      
        
        $image->products()->attach($request->product_id);

        $imgs = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
                                                        ->pluck('image_id'))
                            ->where('main', 1)
                            ->pluck('id');
        //dd($imgs);
        if (count($imgs) == 0) {
            $mainimg = Image::whereIn('id', ImageProduct::where('product_id', $request->product_id)
                                                        ->pluck('image_id'))
                            ->get();
            $mainimg[0]->main = 1;
            $mainimg[0]->save();
        }
        // return redirect()->back()->with('addImages', 'true');
        return redirect()->route('admin.products.addImages', $request->product_id);
    }
}
