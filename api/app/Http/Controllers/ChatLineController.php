<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ChatLineController extends Controller
{
    //

   
    public function index(){
        return view('chat.message');
    }

    public function login(){
        return view('chat.login');
    }

    public function authentication(Request $request){
        dd($request->all());
    }

    public function chatToUser(){

    }
}



