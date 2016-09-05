<?php

namespace App\Services;

use App\Models\AppUser;
use App\Jobs\InstagramPaginationJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Coupon;
use MetzWeb\Instagram\Instagram;

class InstagramGuy
{
    use DispatchesJobs;

    const IMAGES_PER_REQUEST = 12;
    const IMAGES_TOTAL_LIMIT = 24;

    private $instagram;

    public function __construct()
    {
        $this->instagram = new Instagram(array(
            'apiKey' => 'cd9f614f85f44238ace18045a51c44d1',
            'apiSecret' => 'd839149848c04447bd379ce8bff4d890',
            'apiCallback' => 'http://localhost:8000/test' // must point to success.php
        ));
        $this->instagram->setAccessToken("3532720007.cd9f614.f085ab9cf7dc456891b8359a175ef443");
    }

    public function fetchByTag($coupon_id)
    {
        $current = 0;

        $users = AppUser::whereHas('social', function ($query) {
                $query->where('social_type', '=', 1);
            })->with('social')->get()->toArray();

        //dd($users); die();
        foreach ($users as $user) {
            if ($user) {

                $response = $this->instagram->getUserMedia($user['social']['social_id'], self::IMAGES_PER_REQUEST);
                //dd($response); die();

                $client = new \GuzzleHttp\Client();
                while (!empty($response->pagination->next_url) && $current < self::IMAGES_TOTAL_LIMIT) {
                    $this->dispatch(new InstagramPaginationJob($coupon_id, $user['id'], $response->data));
                    $current += self::IMAGES_PER_REQUEST;
                    $response = json_decode($client->get($response->pagination->next_url)
                        ->getBody()
                        ->getContents());
                }  

                if ($response && empty($response->pagination->next_url))
                {
                    $this->dispatch(new InstagramPaginationJob($coupon_id, $user['id'], $response->data));
                }
            }
           
        }
        

    }
}