<?php
namespace App\Repositories\Contracts;
use LINE\LINEBot\Message\MultipleMessages;
use LINE\LINEBot\Message\RichMessage\Markup;
interface ChatLineRepositoryInterface
{
    public function sendTextMessage($mid,$text);
    public function sendImageMessage($mid, $imageURL, $previewURL);
    public function sendVideoMessage($mid, $videoURL, $previewImageURL);
    public function sendAudioMessage($mid, $audioURL, $durationMillis);
    public function sendLocationMessage($mid, $text, $latitude, $longitude);
    public function sendTickerMessage($mid, $stkid, $stkpkgid, $stkver);
    public function sendRichMessage($mid, $imageURL, $altText, Markup $markup);
    public function sendMultipleMessages($mid, MultipleMessages $multipleMessages);
    public function getMessageContent($messageId, $fileHandler = null);
    public function getMessageContentPreview($messageId, $fileHandler = null);
    public function getUserProfile($mid);
    public function validateSignature($json, $signature);


}