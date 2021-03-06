<?php
namespace App\Repositories\Redis;

use App\Repositories\Contracts\UsersRepositoryInterface;

class RedisUsersRepository implements UsersRepositoryInterface
{
    public function all()
    {
        return 'Get all product from Redis';
    }

    public function find($id)
    {
        return 'Get single product by id: ' . $id;
    }
}