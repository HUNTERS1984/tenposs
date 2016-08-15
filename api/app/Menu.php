<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['id', 'name'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'rel_menus_items', 'menu_id', 'item_id');
    }
}
