<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RegisterProcessController extends Controller
{
    //
    public function registerProduct(Request $request){
        return view('pages.registers.register_product');
    }
}
