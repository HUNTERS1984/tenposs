<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ItemsRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Contracts\PhotosRepositoryInterface;
use App\Repositories\Contracts\ReservesRepositoryInterface;
use App\Repositories\Contracts\Top1sRepositoryInterface;
use App\Repositories\Contracts\TopsRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    protected $request;
    protected $_testRepository;

    public function __construct(ItemsRepositoryInterface $ur,Request $request)
    {
        $this->_testRepository = $ur;
        $this->request = $request;
    }
    //
    public function index()
    {
        try
        {
            return $this->_testRepository->getList(0,1,10);
        } catch (QueryException $e)
        {
            return $e;
        }
    }
}
