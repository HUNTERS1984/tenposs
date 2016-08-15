<?php
// app/Repositories/Eloquents/UsersRepository.php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;


class UsersRepository implements UsersRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function paginate($limit){
    	return User::paginate($limit);
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
