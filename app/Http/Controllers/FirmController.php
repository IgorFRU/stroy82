<?php

namespace App\Http\Controllers;

use App\Firm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmController extends Controller
{
    
    public function firmStore(Request $request) {

        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = 0;
        }

        $firm = Firm::where('inn', $request->firm_data['firm_inn'])->first();
        if (!isset($firm)) {
            $firm_data = [
                'inn' => $request->firm_data['firm_inn'],
                'user_id' => $user_id,
                'name' => $request->firm_data['firm_name'],
                'ogrn' => $request->firm_data['firm_ogrn'],
                'okpo' => $request->firm_data['firm_okpo'],
                'index' => $request->firm_data['firm_postal_code'],
                'region' => $request->firm_data['firm_region'],
                'street' => $request->firm_data['firm_street'],
                'status' => $request->firm_data['firm_status'],
            ];
            
            $firm = Firm::create($firm_data);
        }
        // echo json_encode($request->firm_data['firm_inn']);
        echo json_encode($firm);
    }
}
