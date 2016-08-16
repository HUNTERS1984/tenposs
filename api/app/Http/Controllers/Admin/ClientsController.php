<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepositoryInterface;

class ClientsController extends Controller
{
    
	protected $userRespository;
    
    public function __construct(UsersRepositoryInterface $ur)
    {
        $this->userRespository = $ur;
    }
    public function index(){
  
        return view('admin.clients.index',['users'=>$this->userRespository->paginate(2)]);
    }

    public function login(){
      
        return view('admin.login');
    }
}
