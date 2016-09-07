<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\PhotoCat;
use App\Models\Photo;

class PhotoCatController extends Controller
{
    protected $request;
    protected $entity;
    protected $photo;

    public function __construct(Request $request, PhotoCat $photocat, Photo $photo){
        $this->request = $request;
        $this->entity = $photocat;
        $this->photo = $photo;
    }

    public function index()
    {

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

        return redirect()->back();
    }

    public function show($id)
    {

    }

    public function edit(Store $store,$id)
    {
        $all_photocate = $this->entity->all();
        $list_store = $store->lists('name','id');
        $photocate = $this->entity->find($id);
        return view('admin::pages.photocats.edit',compact('photocate','list_store','all_photocate'));
    }

    public function update($id)
    {
        $photocate = $this->entity->find($id);
        $photocate->name = $this->request->input('name');
        $photocate->store_id = $this->request->input('store_id');
        $photocate->save();

        return redirect()->route('admin.photo-cate.index');
    }

    public function destroy($id)
    {
    	$this->entity->destroy($id);
        return redirect()->back();
    }
}
