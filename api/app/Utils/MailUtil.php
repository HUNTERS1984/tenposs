<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/14/16
 * Time: 6:10 PM
 */

namespace App\Utils;


use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailUtil
{
    public static function sendMail($to_email,$to_name,$subject)
    {
        try {
            $data = array(
                'name' => "Tenposs",
                'to_email' => $to_email,
                'to_name' => $to_name,
                'subject' =>$subject
            );
            Mail::send('email.demo', $data, function ($message) use ($data){
                $message->to($data['to_email'],$data['to_name'])->subject($data['subject']);
            });
        }catch (ConnectException $e)
        {
            Log::error("MailUtil:".$e->getMessage());
        }
    }
}