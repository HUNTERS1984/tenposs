<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $table = 'tags';
    public $timestamps = false;
    protected $fillable = ['id', 'tag'];

    public function posts()
    {
        return $this->belongsToMany(Item::class, 'rel_posts_tags', 'tag_id', 'post_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'rel_coupons_tags', 'tag_id', 'coupon_id');
    }
}