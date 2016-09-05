<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Services\InstagramGuy;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstagramHashtagJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $coupon_id;

    /**
     * InstagramHashtagJob constructor.
     *
     * @param $hashtag
     * @param $campaignId
     */
    public function __construct($coupon_id)
    {
        $this->coupon_id = $coupon_id;
    }

    public function handle(InstagramGuy $guy)
    {
        $guy->fetchByTag($this->coupon_id);
    }
}
