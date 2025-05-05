<?php

return [
    'channel_id' => env('LINE_CHANNEL_ID'),
    'secret' => env('LINE_SECRET'),
    'authorize_base_url' => 'https://access.line.me/oauth2/v2.1/authorize',
    'get_token_url' => 'https://api.line.me/oauth2/v2.1/token',
    'get_user_profile_url' => 'https://api.line.me/v2/profile',
    'liff_id' => env('LIFF_ID'),
    'channel_bob_token' => env('LINE_BOT_CHANNEL_TOKEN'),
    'channel_bob_secret' => env('LINE_BOT_CHANNEL_SECRET'),
    'channel_bob_secret' => env('LINE_BOT_CHANNEL_SECRET'),
    'wenbhook_menu_news' => env('LINE_WEBHOOK_MENU_NEWS'),
    'wenbhook_menu_parts' => env('LINE_WEBHOOK_MENU_PARTS'),
    'wenbhook_menu_orders' => env('LINE_WEBHOOK_MENU_ORDERS'),
    'wenbhook_menu_video' => env('LINE_WEBHOOK_MENU_VEIDEO'),
    'wenbhook_menu_user' => env('LINE_WEBHOOK_MENU_USER'),
];


