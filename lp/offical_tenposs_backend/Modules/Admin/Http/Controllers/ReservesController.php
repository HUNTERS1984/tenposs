<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Reserve;
use App\Models\Staff;
use App\Models\StaffCat;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


use Carbon\Carbon;

define('REQUEST_RESERVE_ITEMS', 10);

class ReservesController extends Controller
{
    protected $request;
    protected $reserve;


    public function __construct(Request $request, Reserve $reserve)
    {
        $this->request = $request;
        $this->reserve = $reserve;
    }

    public function index()
    {
        $stores = $this->request->stores;
        $list_item = [];
        $list_store = [];
        if ($stores != null) {
            $list_item = $this->reserve->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
                ->whereNull('deleted_at')->paginate(REQUEST_RESERVE_ITEMS);
            $list_store = $stores->lists('name', 'id');
        }


        return view('admin::pages.reserve.index', compact('list_item', 'list_store'));
    }

    public function create()
    {
        $stores = $this->request->stores;
        $list_store = [];
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
        }
        return view('admin::pages.reserve.create', compact('list_store'));
    }

    public function store()
    {
        $store_id = $this->request->input('store_id');
        $rules = [
            'reserve_url' => 'required|Url'
        ];

        $v = Validator::make($this->request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $item = new Reserve();
            $item->reserve_url = $this->request->input('reserve_url');
            $item->store_id = $store_id;
            $item->save();

            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Add reserve successfully'));
            return redirect()->route('admin.reserve.index')->withSuccess('Add reserve successfully');

        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Add reserve fail'));
            return back();
        }
    }

    public function edit($id)
    {
        $stores = $this->request->stores;
        $list_store = [];
        $item = [];
        if (count($stores) > 0)
            $list_store = $stores;
        try {
            $item = Reserve::find($id);

        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => $e->getMessage()));
            return back();
        }
        return view('admin::pages.reserve.edit', compact('list_store', 'item'));
    }

    public function update($id)
    {
        $store_id = $this->request->input('store_id');
        $rules = [
            'reserve_url' => 'required|Url'
        ];

        $v = Validator::make($this->request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $item = Reserve::find($id);
            $item->reserve_url =  $this->request->input('reserve_url');
            $item->store_id = $store_id;
            $item->save();
            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Update reserve successfully'));
            return redirect()->route('admin.reserve.index')->withSuccess('Update reserve successfully');

        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Update reserve fail'));
            return back();
        }
    }

    public function destroy($id)
    {

        if ($id > 0) {
            Reserve::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        }
        return redirect()->route('admin.reserve.index')->withSuccess('Delete the reserve successfully');
    }

}