<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    protected $table = 'posts';
    public $timestamps = false;
    protected $fillable = ['id', 'social_user_id', 'social_media_id', 'caption', 'description', 'created_time', 'status'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'rel_posts_tags', 'post_id', 'tag_id');
    }

    public function app_user()
    {
        return $this->belongsTo(AppUser::class);
    }
}