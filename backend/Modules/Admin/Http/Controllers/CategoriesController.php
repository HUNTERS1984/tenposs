<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCat;
use App\Utils\RedisControl;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;


use Carbon\Carbon;
use App\Models\News;
use App\Models\Store;


define('REQUEST_CATEGORY_ITEMS', 10);

class CategoriesController extends Controller
{
    protected $request;
    protected $staff_cat;


    public function __construct(Request $request, StaffCat $staffCat)
    {
        $this->request = $request;
        $this->staff_cat = $staffCat;
    }

    public function index()
    {
        $type = $this->request->input('type');
        $stores = $this->request->stores;
        $list_item = [];
        $list_store = [];
        $back_url = $this->get_back_url($type);
        switch ($type) {
            case 'staff':
                if ($stores != null) {
                    $list_item = $this->staff_cat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
                        ->whereNull('deleted_at')->paginate(REQUEST_CATEGORY_ITEMS);
                    $list_store = $stores->lists('name', 'id');
                }
                break;
            default:
                break;
        }
//        dd($list_item->toArray());

        return view('admin::pages.category.index', compact('list_item', 'list_store', 'type','back_url'));
    }

    public function create()
    {
        $stores = $this->request->stores;
        $type = $this->request->input('type');
        $list_store = [];
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
        }
        return view('admin::pages.category.create', compact('list_store', 'type'));
    }

    public function store()
    {
        $type = $this->request->input('type');
        $store_id = $this->request->input('store_id');
        $rules = [
            'name' => 'required|Max:255'
        ];

        $v = Validator::make($this->request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            switch ($type) {
                case 'staff':
                    $name = $this->request->input('name');
                    $item = new StaffCat();
                    $item->name = $name;
                    $item->store_id = $store_id;
                    $item->save();
                    break;
                default:
                    break;
            }
            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Add category successfully'));
            return redirect()->route('admin.category.index', array('type' => $type))->withSuccess('Add category successfully');

        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Add category fail'));
            return back();
        }
    }

    public function edit($id)
    {
        $type = $this->request->input('type');
        $stores = $this->request->stores;
        $list_store = [];
        $item = [];
        if (count($stores) > 0)
            $list_store = $stores;
        try {
            switch ($type) {
                case 'staff':
                    $item = StaffCat::find($id);
                    break;
                default:
                    break;
            }
        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => $e->getMessage()));
            return back();
        }
        return view('admin::pages.category.edit', compact('list_store', 'type', 'item'));
    }

    public function update($id)
    {
        $type = $this->request->input('type');
        $store_id = $this->request->input('store_id');
        $rules = [
            'name' => 'required|Max:255'
        ];

        $v = Validator::make($this->request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            switch ($type) {
                case 'staff':
                    $name = $this->request->input('name');
                    $item = new StaffCat();
                    $item->name = $name;
                    $item->store_id = $store_id;
                    $item->save();
                    break;
                default:
                    break;
            }
            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Update category successfully'));
            return redirect()->route('admin.category.index', array('type' => $type))->withSuccess('Add category successfully');

        } catch (QueryException $e) {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Update category fail'));
            return back();
        }
    }

    public function destroy($id, $type)
    {
        switch ($type) {
            case 'staff':
                if ($id > 0) {
                    StaffCat::where('id', $id)->update(['deleted_at' => Carbon::now()]);
                    Staff::where('staff_category_id', $id)->update(['deleted_at' => Carbon::now()]);
//                    $this->staff_cat->destroy($id);
                }
                break;
            default:
                break;
        }

        return redirect()->route('admin.category.index', array('type' => 'staff'))->withSuccess('Delete the category successfully');
    }

    private function get_back_url($type)
    {
        $url = 'admin.news.index';
        switch ($type) {
            case 'staff':
                $url = 'admin.staff.index';
                break;
            case 'news':
                $url = 'admin.news.index';
                break;
            case 'menus':
                $url = 'admin.menus.index';
                break;
            case 'coupon':
                $url = 'admin.coupon.index';
                break;
            case 'photo-cate':
                $url = 'admin.photo-cate.index';
                break;
            default:
                break;
        }
        return $url;
    }
}