<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Menus;

class MenusController extends Controller
{
    protected $request;
    protected $entity;

    public function __construct(Request $request, Menus $menus){
        $this->request = $request;
        $this->entity = $menus;
    }
    public function index(Menus $menu,Store $store)
    {
        $menus = $menu->all();
        $list_store = $store->lists('name','id');
        return view('admin::pages.menus.index',compact('menus','list_store'));
    }

    public function create()
    {

    }

    public function store()
    {
        $data = [
            'name' => $this->request->input('name'),
            'store_id' => $this->request->input('store_id'),
        ];
        $this->entity->create($data);

        return redirect()->route('admin.menus.index');
    }

    public function show($id)
    {

    }

    public function edit(Store $store, $id)
    {
        $all_menus = $this->entity->all();
        $list_store = $store->lists('name','id');
        $menus = $this->entity->find($id);
        return view('admin::pages.menus.edit',compact('menus','list_store','all_menus'));
    }

    public function update($id)
    {
        
        $menus = $this->entity->find($id);
        $menus->name = $this->request->input('name');
        $menus->store_id = $this->request->input('store_id');
        $menus->save();

        return redirect()->route('admin.menus.index');
    }

    public function destroy($id)
    {
    	$this->entity->destroy($id);
        return redirect()->back();
    }
}

