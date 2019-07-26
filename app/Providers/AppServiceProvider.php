<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Category;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

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

        Category::saving(function(Category $model){
            $model->slug = Str::slug(mb_substr($model->category, 0, 60) . "-", "-");
            $double = Category::where('slug', $model->slug)->first();
            if ($double) {
                $next_id = Category::select('id')->orderby('id', 'desc')->first()['id'];
                $model->slug .= '-' . ++$next_id;
            }

            if($model->image) {
                $path = public_path().'\imgs\categories\\';
                $file = $model->image;
                $base_name = str_random(20);
                $filename = $base_name .'.' . $file->getClientOriginalExtension() ?: 'png';
                $img = ImageManagerStatic::make($file);
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $model->image = $filename;
            }
        });
    }
}
