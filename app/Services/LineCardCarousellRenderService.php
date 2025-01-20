<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\LineCardTemplate;
use App\Models\LineCard;


class LineCardCarousellRenderService
{

    private function renderBtn($ctx) {
        
        $btn = $ctx['btn'];
        $vcard = $ctx['vcard'];
        $uri = trim($btn['link'] ?? "");
        
        return [
            'color' => $btn['color'] ?? '#17c950',
            'height' => $vcard['btnHeight'] ?? 'md',
            'style' => $btn['style'] ?? 'primary',
            'type' => 'button',
            'action' => [
                'label' => $btn['text'] ?? '預設按鈕文字',
                'type' => 'uri',
                'uri' => $uri,
            ],
        ];
    }

    private function renderCard($ctx) {
        $card = $ctx['card'];
        $cardIdx = $ctx['cardIdx'];
        $vcard = $ctx['vcard'];
        $uri = trim($card['link'] ?? "");
        
        $contents = [
            [
                'color' => $card['titleColor'] ?? '#000000',
                'size' => $vcard['titleSize'] ?? 'xl',
                'text' => $card['title'],
                'type' => 'text',
                'weight' => 'bold',
                'wrap' => true,
            ],
            [
                'color' => $card['descColor'] ?? '#000000',
                'size' => $vcard['descSize'] ?? 'sm',
                'text' => $card['desc'],
                'type' => 'text',
                'wrap' => true,
            ],
        ];

        /*if ($cardIdx === 0) {
            $contents[] = [
                'height' => '1px',
                'layout' => 'vertical',
                'offsetStart' => '0px',
                'offsetTop' => '0px',
                'position' => 'absolute',
                'type' => 'box',
                'width' => '1px',
                'contents' => [[
                    'align' => 'center',
                    'aspectMode' => 'cover',
                    'aspectRatio' => '1:1',
                    'gravity' => 'center',
                    'size' => 'full',
                    'type' => 'image',
                    'url' => "",
                ]],
            ];
        }*/

        return [
            'type' => 'bubble',
            'hero' => [
                'animated' => $cardIdx < 10,
                'aspectMode' => 'cover',
                'aspectRatio' => $vcard['ratio'] ?? '20:13',
                'size' => 'full',
                'type' => 'image',
                'url' => $card['image'] ?? '',
                'action' => [
                    'type' => 'uri',
                    'uri' => $uri,
                ],
            ],
            'body' => [
                'backgroundColor' => $card['bgColor'] ?? '#ffffff',
                'layout' => 'vertical',
                'spacing' => 'md',
                'type' => 'box',
                'action' => [
                    'type' => 'uri',
                    'uri' => $uri,
                ],
                'contents' => $contents,
            ],
            'footer' => [
                'backgroundColor' => $card['bgColor'] ?? '#ffffff',
                'layout' => 'vertical',
                'spacing' => 'sm',
                'type' => 'box',
                'contents' => array_map(function($btn) use ($ctx) {
                    return $this->renderBtn(array_merge($ctx, ['btn' => $btn]));
                }, $card['btns']),
            ],
        ];
    }

    public function render($ctx) {
        $vcard = $ctx['vcard'];
        return [
            'type' => 'flex',
            'altText' => $vcard['altText'],
            'contents' => [
                'type' => 'carousel',
                'contents' => array_map(function($card, $cardIdx) use ($ctx) {
                    return $this->renderCard(array_merge($ctx, ['card' => $card, 'cardIdx' => $cardIdx]));
                }, $vcard['cards'], array_keys($vcard['cards'])),
            ],
        ];
    }


}