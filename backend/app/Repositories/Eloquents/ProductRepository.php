<?php
// app/Repositories/Eloquents/ProductRepository.php

namespace App\Repositories\Eloquents;

use App\User;
use App\Repositories\Contracts\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }
}
