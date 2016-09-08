<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    public $table = 'items';
    protected $fillable = ['price','image_url','description', 'title','coupon_id'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'rel_menus_items', 'item_id', 'menu_id');
    }

    public function rel_items()
    {
        return $this->belongsToMany(Item::class, 'rel_items', 'item_id', 'related_id')->select(['id', 'price','image_url','description', 'title'])->take(8);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function coupons(){
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

}
