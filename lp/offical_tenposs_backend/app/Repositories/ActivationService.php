<?php

namespace App\Repositories;


use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use App\Models\User;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {

        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $url_authorize = route('user.activate', $token);
       
    	$this->mailer->send('emails.register',
			 array('user' => $user, 'url_authorize' => $url_authorize)
			 ,function($message) use ( $user ) {
				 $message->from( config('mail.from')['address'], config('mail.from')['name'] );
				 $message->to( $user->email )
					 //->cc()
					 ->subject('【Tenposs】新規登録のお知らせ');
			 });   
       
        
        /*
        $this->mailer->raw($message, function (Message $m) use ($user) {
            $m->to($user->email)->subject('Activation mail');
        });*/


    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);
        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}