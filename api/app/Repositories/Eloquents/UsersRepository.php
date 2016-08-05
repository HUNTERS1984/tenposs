<?php
// app/Repositories/Eloquents/UsersRepository.php

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
