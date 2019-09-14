<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmController extends Controller
{
    
    public function firmStore(Request $request) {

        $firm = Firm::where('inn', $request->firm_inn)->get();
        if ($firm->count() == 0) {
            $firm_data = [
                'inn' => $request->firm_inn,
                'name' => $request->firm_name,
                'ogrn' => $request->firm_ogrn,
                'okpo' => $request->firm_okpo,
                'index' => $request->firm_postal_code,
                'region' => $request->firm_region,
                'street' => $request->firm_street,
                'status' => $request->firm_status,
            ];
            
            $firm = Firm::create($firm_data);
        }
        echo json_encode($firm);
    }
}
