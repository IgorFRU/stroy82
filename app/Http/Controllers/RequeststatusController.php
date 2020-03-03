<?php

namespace App\Http\Controllers;

use App\Requeststatus;
use Illuminate\Http\Request;

class RequeststatusController extends Controller
{
    public function getStatus(Request $request) {
        $status = Requeststatus::create(['requeststatus' => $request->all()]);
    }
}
