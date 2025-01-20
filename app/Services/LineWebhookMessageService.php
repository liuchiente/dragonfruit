<?php

namespace App\Services;

use App\Models\LineMessageLog;
use App\Models\MessageText;
use App\Models\MessageImage;
use App\Models\MessageVideo;
use App\Models\MessageAudio;
use App\Models\MessageFile;
use App\Models\MessageLocation;

class LineWebhookMessageService
{
    public $plan_text;
    public $destination;
    public $replyToken;
    public $type;
    public $webhookEventId;
    public $mode;
    public $timestamp;
    public $message;
    public $emojis;
    public $mentionees;
    public $source;

    public function __construct(array $data)
    {
        // 設置屬性
        $this->plan_text = json_encode($data); // 儲存原始 JSON 字串
        $this->destination = $data['destination'];
        $this->replyToken = $data['events'][0]['replyToken'];
        $this->type = $data['events'][0]['type'];
        $this->webhookEventId = $data['events'][0]['webhookEventId'];
        $this->mode = $data['events'][0]['mode'];
        $this->timestamp = $data['events'][0]['timestamp'];
        $this->message = $data['events'][0]['message'];
        $this->emojis = $data['events'][0]['message']['emojis'] ?? [];
        $this->mentionees = $data['events'][0]['message']['mention']['mentionees'] ?? [];
        $this->source = $data['events'][0]['source'];
    }

    public function saveMessageLog()
    {
        // 儲存訊息紀錄
        $log = new LineMessageLog();
        $log->webhook_event_id = $this->webhookEventId;
        $log->type = $this->type;
        $log->timestamp = $this->timestamp;
        $log->source_type = $this->source['type'];
        $log->group_id = $this->source['groupId'] ?? null;
        $log->user_id = $this->source['userId'] ?? null;
        $log->message_type = $this->message['type'];
        $log->save();
    }

    public function saveMessageText()
    {
        // 如果訊息類型是文字，儲存文字訊息
        if ($this->message['type'] === 'text') {
            $text = new MessageText();
            $text->message_id = $this->message['id'];
            $text->text = $this->message['text'];
            $text->save();
        }
    }

    public function saveMessageImage()
    {
        // 如果訊息類型是圖片
        if ($this->message['type'] === 'image') {
            if ($this->message['contentProvider']['type'] === 'line') {
                $image = new MessageImage();
                $image->message_id = $this->message['id'];
                $image->save();
            } elseif ($this->message['contentProvider']['type'] === 'external') {
                $image = new MessageImage();
                $image->image_set_id = $this->message['imageSet']['id'];
                $image->save();
            }
        }
    }

    public function saveMessageVideo()
    {
        // 如果訊息類型是影片
        if ($this->message['type'] === 'video') {
            if ($this->message['contentProvider']['type'] === 'line') {
                $video = new MessageVideo();
                $video->message_id = $this->message['id'];
                $video->save();
            } elseif ($this->message['contentProvider']['type'] === 'external') {
                $video = new MessageVideo();
                $video->original_content_url = $this->message['contentProvider']['originalContentUrl'];
                $video->save();
            }
        }
    }

    public function saveMessageAudio()
    {
        // 如果訊息類型是音訊
        if ($this->message['type'] === 'audio') {
            if ($this->message['contentProvider']['type'] === 'line') {
                $audio = new MessageAudio();
                $audio->message_id = $this->message['id'];
                $audio->save();
            } elseif ($this->message['contentProvider']['type'] === 'external') {
                $audio = new MessageAudio();
                $audio->original_content_url = $this->message['contentProvider']['originalContentUrl'];
                $audio->save();
            }
        }
    }

    public function saveMessageFile()
    {
        // 如果訊息類型是檔案
        if ($this->message['type'] === 'file') {
            $file = new MessageFile();
            $file->message_id = $this->message['id'];
            $file->file_name = $this->message['fileName'];
            $file->file_size = $this->message['fileSize'];
            $file->save();
        }
    }

    public function saveMessageLocation()
    {
        // 如果訊息類型是位置
        if ($this->message['type'] === 'location') {
            $location = new MessageLocation();
            $location->message_id = $this->message['id'];
            $location->title = $this->message['title'];
            $location->address = $this->message['address'];
            $location->latitude = $this->message['latitude'];
            $location->longitude = $this->message['longitude'];
            $location->save();
        }
    }
}
