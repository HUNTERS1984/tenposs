<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCat;
use App\Utils\RedisControl;
use Illuminate\Http\Request;
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
        switch ($type) {
            case 'staff':
                if ($stores != null) {
                    $list_item = $this->staff_cat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->paginate(REQUEST_CATEGORY_ITEMS);
                    $list_store = $stores->lists('name', 'id');
                }
                break;
            default:
                break;
        }
//        dd($list_item->toArray());

        return view('admin::pages.category.index', compact('list_item', 'list_store','type'));
    }

    public function destroy($id, $type)
    {
        switch ($type) {
            case 'staff':
                if ($id > 0) {
                    Staff::where('staff_category_id', $id)->update(['deleted_at'=> Carbon::now()]);
                    $this->staff_cat->destroy($id);
                }
                break;
            default:
                break;
        }

        return redirect()->route('admin.category.index')->withSuccess('Delete the category successfully');
    }
}