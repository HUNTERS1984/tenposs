<?php
namespace App\Repositories\Contracts;
interface ItemsRepositoryInterface
{
    public function getList($menu_id,$pageindex,$pagesize);
    public function getDetail($item_id);

}