<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Category;
use App\Article;
use App\Product;
use App\Manufacture;
use App\Http\Services\WorkWithImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); //NEW: Increase StringLength

        Category::creating(function(Category $model){
            $model->slug = Str::slug(mb_substr($model->category, 0, 60) . "-", "-");
            $double = Category::where('slug', $model->slug)->first();
            if ($double) {
                $next_id = Category::select('id')->orderby('id', 'desc')->first()['id'];
                $model->slug .= '-' . ++$next_id;
            }

            if($model->image) {
                // dd($model);
                $path = public_path().'\imgs\categories\\';
                $file = $model->image;
                $img = new WorkWithImage($file, $path);
                $model->image = $img->saveImage();
            }
        });

        Category::updating(function(Category $model) {
            if($model->image) {
                // dd($model->image);
                $old_image = Category::select('image')->find($model->id);
                // dd($old_image->image);
                if($model->image != $old_image->image) {

                    if (file_exists(public_path().'\imgs\categories\\' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'\imgs\categories\\' . $old_image->image);
                    }
                    $path = public_path().'\imgs\categories\\';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }
                
            }
        });

        Article::creating(function(Article $model){
            // $model->slug = Str::slug(mb_substr($model->article, 0, 60) . "-", "-");
            // $double = Article::where('slug', $model->slug)->first();
            // if ($double) {
            //     $next_id = Article::select('id')->orderby('id', 'desc')->first()['id'];
            //     $model->slug .= '-' . ++$next_id;
            // }
            if($model->image) {
                // dd($model);
                $path = public_path().'\imgs\articles\\';
                if (!file_exists($path)) {
                    mkdir($path, 0777);
                }
                $file = $model->image;
                $img = new WorkWithImage($file, $path);
                $model->image = $img->saveImage();
            }
        });

        Article::updating(function(Article $model) {
            if($model->image) {
                $old_image = Article::select('image')->find($model->id);
                if($model->image != $old_image->image) {
                    if (file_exists(public_path().'\imgs\articles\\' . $old_image->image)) {                        
                        $file = new Filesystem;
                        $file->delete(public_path().'\imgs\articles\\' . $old_image->image);
                    }
                    $path = public_path().'\imgs\articles\\';
                    $file = $model->image;
                    $img = new WorkWithImage($file, $path);
                    $model->image = $img->saveImage();
                }                
            }
        });


        // Product::creating(function(Product $model){
        //     $model->slug = Str::slug(mb_substr($model->product, 0, 60), "-");
        //     if ($model->scu) {
        //         $model->slug .= $model->scu;
        //     }
        //     $double = Product::where('slug', $model->slug)->first();
        //     if ($double) {
        //         $next_id = Product::select('id')->orderby('id', 'desc')->first()['id'];
        //         $model->slug .= '-' . ++$next_id;
        //     }
        // });

        // Manufacture::creating(function(Manufacture $model){
        //     if($model->image) {
        //         // dd($model);
        //         $path = public_path().'\imgs\manufactures\\';
        //         $file = $model->image;
        //         $img = new WorkWithImage($file, $path);
        //         $model->image = $img->saveImage();
        //     }
        // });

        // Manufacture::updating(function(Manufacture $model) {
        //     if($model->image) {
        //         // dd($model->image);
        //         $old_image = Manufacture::select('image')->find($model->id);
        //         // dd($old_image->image);
        //         if($model->image != $old_image->image) {
        //             $file = new Filesystem;
        //             $file->delete(public_path().'\imgs\manufactures\\' . $old_image->image);
        //             $path = public_path().'\imgs\manufactures\\';
        //             $file = $model->image;
        //             $img = new WorkWithImage($file, $path);
        //             $model->image = $img->saveImage();
        //         }
                
        //     }
        // });
    }
}
