<?php
// app/Repositories/Eloquents/UsersRepository.php

namespace App\Repositories\Eloquents;

use App\Models\Users;
use App\Repositories\Contracts\UsersRepositoryInterface;


class UsersRepository implements UsersRepositoryInterface
{
    public function all()
    {
        return Users::all();
    }

    public function paginate($limit){
    	return Users::paginate($limit);
    }

    public function find($id)
    {
        return Users::findOrFail($id);
    }
}
