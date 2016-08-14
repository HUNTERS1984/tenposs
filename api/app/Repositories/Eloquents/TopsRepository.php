<?php
namespace App\Repositories\Eloquents;

use App\AppSetting;
use App\Item;
use App\Models\News;
use App\Photo;
use App\TopMainImage;
use App\User;
use App\Repositories\Contracts\TopsRepositoryInterface;
use DB;

class TopsRepository implements TopsRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function getTopItem()
    {
        return Item::all()->take(10);
    }

    public function getTopPhoto()
    {
//        return Photo::all()->take(10);
//        return DB::table('photos')
//            ->join('photo_categories', 'photo_categories.id', '=', 'photos.photo_category_id')
//            ->select('photos.id','photos.image_url','photos.photo_category_id', 'photo_categories.name')
//            ->paginate(6);
        return DB::select('select p.id,p.image_url,p.photo_category_id,pc.`name` from `photos` p 
                            inner join `photo_categories` pc
                            on p.photo_category_id = pc.id 
                            order by p.id desc
                            limit 10
                            ');

    }

    public function getTopNew()
    {
        return News::all(['id','title','description','date','store_id','image_url'])->take(10);
    }

    public function getTopMainImage()
    {
        return TopMainImage::all(['id','image_url'])->take(10);
    }

    public function getAppInfo($id)
    {
        $appSetting = AppSetting::find($id);

    }
}