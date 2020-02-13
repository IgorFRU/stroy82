<?php

namespace App\Http\Controllers;

use App\Banner;

use App\Http\Services\WorkWithImage;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class BannerController extends Controller
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
        $banners = Banner::published()->get();

        $data = [
            'title' => 'Баннеры',
            'banners' => $banners,
        ];

        return view('admin.banners.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'title' => 'Новый баннер',
            'banner' => [],
        );
        
        return view('admin.banners.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request->image) {
            $path = public_path().'/imgs/banners/';
            if (!file_exists($path)) {
                mkdir($path, 0777);
            }
            $file = $request->image;
            $img = new WorkWithImage($file, $path);
            $image = $img->saveImage();
        } else {
            redirect()->back()->with('error', 'Необходимо загрузить изображение!');
        }

        $validatedData = $request->validate([
            'image' => 'required',
            'title' => 'max:255',
            'description' => 'max:255',
            'link' => 'max:255',
        ]);
        $banner = Banner::create($request->except('image'));  
        $banner->image = $image;
        $banner->update();     
        
        return redirect()->route('admin.banners.index')->with('success', 'Баннер успешно создан!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        if (file_exists(public_path('imgs/banners/'. $banner->image))) {
            try {
                $file = new Filesystem;
                $file->delete(public_path('imgs/banners/'. $banner->image));
            } catch (\Throwable $th) {
                echo 'Сообщение: '   . $th->getMessage() . '<br />';
            }                
        }
        // unlink(public_path('imgs/articles/'.$article->image));
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Баннер удалён!');
    }
}
