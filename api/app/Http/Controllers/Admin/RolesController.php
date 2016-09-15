<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Session;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.roles.index', ['roles' => Role::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = array(
            'name' => array('required','regex:/^[a-zA-Z]+$/u')
        );
        $messages = [
            'name' => array(
                'regex' => "Only a-z character, no space and no specified character."
            )
        ];
        $v = Validator::make($request->all(),$rule,$messages);
        if( $v->fails()){
            return back()->withInput()->withErrors($v);
        }
        $role = new Role;
        $role->name = $request->input('name');
        $role->save();
        
        Session::flash('message', array('class' => 'alert-success', 'detail' => 'Create role successful'));
        return redirect()->route('admin.roles.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('admin.roles.edit',['role' => Role::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rule = array(
            'id' => 'required',
            'name' => 'required',
        );
        $v = Validator::make($request->all(),$rule);
        if( $v->fails()){
            return back()->withInput()->withErrors($v);
        }
        $role = Role::findOrFail($id)->update(
            ['name' => $request->input('name')]
        );
       
        Session::flash('message', array('class' => 'alert-success', 'detail' => 'Update role successful'));
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
