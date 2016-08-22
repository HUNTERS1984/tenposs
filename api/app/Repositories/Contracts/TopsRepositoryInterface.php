<?php
namespace App\Repositories\Contracts;
interface TopsRepositoryInterface
{
    public function get_top_items($app_app_id);
    public function get_top_photos($app_app_id);
    public function get_top_news($app_app_id);
    public function get_top_contacts($app_app_id);
    public function get_app_info($app_app_id);
    public function list_app();
    public function get_app_info_array($app_app_id);
    public function get_app_info_from_token($token);
}