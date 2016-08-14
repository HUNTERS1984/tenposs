<?php
namespace App\Repositories\Contracts;
interface TopsRepositoryInterface
{
    public function all();
    public function find($id);
    public function getTopItem();
    public function getTopPhoto();
    public function getTopNew();
    public function getTopMainImage();
    public function getAppInfo($id);
}