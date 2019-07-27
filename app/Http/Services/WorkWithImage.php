<?php

namespace App\Http\Services;

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class WorkWithImage 
{
    protected $randomString;
    protected $filename;
    protected $file;
    protected $path;

    public function __construct($file, $path) {
        // dd($file);
        $this->file = $file;
        $this->path = $path;
        $this->randomString = str_random(20);
        $this->filename = $this->randomString .'.' . $file->getClientOriginalExtension() ?: 'png';
        
    }

    public function saveImage() {
        $img = ImageManagerStatic::make($this->file);
        $img->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($this->path . $this->filename);
        $img->destroy();
        return $this->filename;
        
    }
}