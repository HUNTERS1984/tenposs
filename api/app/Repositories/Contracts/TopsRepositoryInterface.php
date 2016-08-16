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
    public function setPushKey();
    public function get_app_info($app_app_id);
    public function get_user_session($token);
    public function list_app();
}