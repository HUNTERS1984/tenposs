<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\UsersRepositoryInterface;

use App\Http\Requests\API\CreateUserAPIRequest;

use App\Utils\ResponseUtil;

class UserController extends Controller
{
    protected $userRespository;
    //
    public function __construct(UsersRepositoryInterface $ur)
    {
        $this->userRespository = $ur;
    }
    public function index(){
        return ResponseUtil::success($this->userRespository->all());
        return $this->userRespository->all();
    }
    public function show($id){
        return $this->userRespository->all($id);
    }

    public function store(CreateUserAPIRequest $request){
        
    }
}
