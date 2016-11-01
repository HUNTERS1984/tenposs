<?php

namespace App\Listeners;

use App\Events\SendEmailCustomer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendEmailCustomerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendEmailCustomer  $event
     * @return void
     */
    public function handle(SendEmailCustomer $event)
    {
        $data = [];
        Mail::send('emails.customer',$data,function($mes) use ($event){
            $mes->from(config('mail.from')['address']);
            $mes->to($event->emailTo);
            $mes->subject($event->subject);
        });
    }
}
