<?php
namespace App\Repositories\Contracts;
interface NewsRepositoryInterface
{
    public function getList($store_id,$pageindex,$pagesize);
    public function getDetail($new_id);
}