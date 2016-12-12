<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Coupon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstagramPaginationJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $coupon_id;

    private $images;

    private $user_id;

    /**
     * InstagramPaginationJob constructor.
     *
     * @param $coupon_id
     * @param $images
     */
    public function __construct($coupon_id, $user_id, array $images)
    {
        $this->coupon_id = $coupon_id;
        $this->images = $images;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hashtag = Coupon::find($this->coupon_id)->tags()->lists('tag')->toArray();
        
        foreach ($this->images as $item) {
            if ($item->type != 'image') {
                continue;
            }

            $tag_list = $item->tags;
            if ($item->caption !== null) {
                preg_match_all('/#([^\s]+)/', $item->caption->text, $matches);
                if (count($matches[1]) > 0)
                {
                    $tag_list = array_unique(array_merge($tag_list, $matches[1]));
                } 
            }                 
           
            if (count($tag_list) == 0)
                continue;
            

            $result = array_intersect(array_map('strtolower', $hashtag), array_map('strtolower', $tag_list));
            if (count($result) == 0)
                continue;
            //dd($result); die();

            $post = Post::where('social_media_id','=',$item->id)->first();
            if ($post === null) {
                $post = new Post();
                $post->app_user_id = $this->user_id;
                $post->social_user_name = $item->user->username;
                $post->social_user_avatar = $item->user->profile_picture;
                $post->social_media_id = $item->id;
                $post->url = $item->link;
                if (@getimagesize($item->images->standard_resolution->url)) {
                    $post->image_url = $item->images->standard_resolution->url;
                } else {
                    $post->image_url = '/img/img-vlg.png';
                }
                // $post->comments_count = $item->comments->count;
                // $post->likes_count = $item->likes->count;
                if ($item->caption !== null) {
                    $post->caption = $item->caption->text;
                }
                $post->created_time = $item->created_time;
                $post->save();
            }

            foreach ($tag_list as $tagName) {
                $tag = Tag::whereTag($tagName)
                    ->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->tag = $tagName;
                    $tag->save();
                }
                try {
                    $tag->posts()->attach($post->id);
                } catch (\Illuminate\Database\QueryException $e) {
                }
            }
            
        }
    }
}
