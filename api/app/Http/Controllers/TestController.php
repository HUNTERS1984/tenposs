<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ItemsRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Repositories\Contracts\Top1sRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    protected $request;
    protected $_testRepository;

    public function __construct(NotificationRepositoryInterface $ur  ,Request $request)
    {
        $this->_testRepository = $ur;
        $this->request = $request;
    }
    //
    public function index()
    {
        return Hash::make(123456);
//        echo '1';die;
        $value = $this->_testRepository->get_info_nofication(1,"chat");
        return $value;
        // try
        // {
        //     return $this->_testRepository->getList(0,1,10);
        // } catch (QueryException $e)
        // {
        //     return $e;
        // }
    }
}
