<?php
namespace App\Repositories\Contracts;
interface PhotosRepositoryInterface
{
    public function getList($category_id,$pageindex,$pagesize);
}