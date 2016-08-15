<?php
namespace App\Repositories\Contracts;
interface ReservesRepositoryInterface
{
    public function getList($store_id);
}