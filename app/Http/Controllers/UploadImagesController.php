<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageU;
use app\Image;
use app\ImageProduct;
use app\Product;
use Illuminate\Support\Str;

class UploadImagesController extends Controller
{
    public function product(Request $request)
    {
        // $file_tmp[] = $_FILES['image']['tmp_name'];
        $path = public_path().'\imgs\products\\';
        $path_thumbnail = public_path().'\imgs\products\thumbnails\\';
        $file = $request->file('image');

        $base_name = str_random(20);
        $productname = Str::slug(mb_substr($request->product, 0, 60), "-");

        $filename = $base_name .'.' . $file->getClientOriginalExtension() ?: 'png';
        $filename_thumbnail = $base_name .'_thumbnail.' . $file->getClientOriginalExtension() ?: 'png';
        $img = ImageU::make($file);
        $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($path . $filename);
        $thumbnail = $img->resize(250, null, function ($constraint) {
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
            'file' => $filename, 
            'name' => $request->name,
            'productname' => $productname,
            'alt' => $request->alt,
            'thumbnail' => $filename_thumbnail,
            'main' => $request->main
            ]);
        
        // $product = Product::find($request->product_id);
        // $product->thumbnail = $filename_thumbnail;        
        // $product->save();

        // Product::where('id', $request->product_id)
        //   ->update(['thumbnail' => $filename_thumbnail]);

        //ImageProduct

        
        
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
            // dd($mainimg[0]);
        }

        return redirect()->back()->with('success', 'Изображение загружено');
    }
}
