<?php

namespace App\Http\Controllers;

use App\Product;
use App\Vendor;
use App\Unit;
use App\Category;

use Excel;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Manufacture;

class ImportexportController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {

        $products = Product::imported()->orderBy('id', 'desc')->paginate(20);

        $data = array (
            'title' => 'Импорт/Экспорт',
            'products' => $products,
        ); 

        return view('admin.importexport.index', $data);
    }

    public function update(Request $request) {

        if (isset($request->file)) {
            
            $request->validate([
                'file' => 'required|file|max:10000|mimes:xls,xlsx',
            ]);
            
            $excel = new ProductsUpdate($request->first_line - 1, $request->all(), $request->last_line);
            Excel::import($excel, $request->file);

            return redirect()->route('admin.import-export.index');
        }

        $data = array (
            'title' => 'Обновление цен',
            
        );

        return view('admin.import.update', $data);
    }

    public function import(Request $request) {
        
        if (isset($request->file)) {
            $request->validate([
                'file' => 'required|file|max:10000|mimes:xls,xlsx',
            ]);
            // dd($request->all()); 
            
            $excel = new ProductsImport($request->first_line - 1, $request->all(), $request->last_line, $request->packaging);
            Excel::import($excel, $request->file);

            return redirect()->route('admin.import-export.index');
        }

        $data = array (
            'title' => 'Импорт товаров',
            'delimiter' => '',
            'vendors' => Vendor::get(),
            'units' => Unit::get(),
            'manufactures' => Manufacture::get(),
            'categories' => Category::with('children')->where('category_id', '0')->get(),
        ); 

        return view('admin.import.index', $data);    
    }    
}
