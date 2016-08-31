<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';
    protected $fillable = ['price','image_url','description', 'title'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'rel_menus_items', 'item_id', 'menu_id');
    }

    public function rel_items()
    {
        return $this->belongsToMany(Item::class, 'rel_items', 'item_id', 'related_id')->select(['id', 'price','image_url','description', 'title'])->take(8);
    }

}
