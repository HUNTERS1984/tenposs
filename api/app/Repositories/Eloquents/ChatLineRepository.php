<?php
// app/Repositories/Eloquents/ChatLineRepository.php

namespace App\Repositories\Eloquents;

use App\User;
use App\Models\UserMessages;
use App\Repositories\Contracts\ChatLineRepositoryInterface;
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
use \LINE\LINEBot\Message\MultipleMessages;
use \LINE\LINEBot\Message\RichMessage\Markup;


class ChatLineRepository implements ChatLineRepositoryInterface
{
    private $bot;
    private $config;
    public function __construct(){

        $this->config = [
            'channelId' => config('linechat.channelId'),
            'channelSecret' =>  config('linechat.channelSecret'),
            'channelMid' =>  config('linechat.channelMid')
        ];
        $this->bot = new LINEBot($this->config, new GuzzleHTTPClient($this->config));
    }
    public function sendTextMessage($mid,$text){
        $res = $this->bot->sendText($mid, $text);
        return $res;
    }
    public function sendImageMessage($mid, $imageURL, $previewURL){

    }
    public function sendVideoMessage($mid, $videoURL, $previewImageURL){}
    public function sendAudioMessage($mid, $audioURL, $durationMillis){}
    public function sendLocationMessage($mid, $text, $latitude, $longitude){}
    public function sendTickerMessage($mid, $stkid, $stkpkgid, $stkver){}
    public function sendRichMessage($mid, $imageURL, $altText, Markup $markup){

    }
    public function sendMultipleMessages($mid, MultipleMessages $multipleMessages){

    }
    public function getMessageContent($messageId, $fileHandler = null){}
    public function getMessageContentPreview($messageId, $fileHandler = null){}
    public function getUserProfile($mid){}
    public function validateSignature($json, $signature){

    }
}
