<?php
// app/Repositories/Eloquents/UsersRepository.php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;
use DB;

class UsersRepository implements UsersRepositoryInterface
{
    public function all()
    {

        return User::orderByRaw(DB::raw("FIELD(status, 2)"))->get()->all();
    }

    public function paginate($limit){
    	return User::orderByRaw(DB::raw("FIELD(status, 2) DESC"))->paginate($limit);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function login()
    {
        // TODO: Implement login() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
