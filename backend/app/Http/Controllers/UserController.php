<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\UsersRepositoryInterface;


class ProductsController extends Controller
{
    protected $userRespository;
    //
    public function __construct(UsersRepositoryInterface $ur)
    {
        $this->userRespository = $ur;
    }
    public function index(){
        return $this->userRespository->all();
    }
    public function show($id){
        return $this->userRespository->all($id);
    }
}
