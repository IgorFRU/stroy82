<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportexportController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        
        $data = array (
            'title' => 'Импорт/Экспорт',
        ); 

        return view('admin.importexport.index', $data);
    }

    public function import() {
        
    }
}
