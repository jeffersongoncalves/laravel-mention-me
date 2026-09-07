<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mention Me API Key
    |--------------------------------------------------------------------------
    |
    | Your Mention Me API key, sent as a Bearer token on every request.
    | Find yours in your Mention Me partner dashboard.
    |
    */
    'api_key' => env('MENTIONME_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The Mention Me v2 REST API base URL. Override only if Mention Me gives
    | you a dedicated endpoint.
    |
    */
    'base_url' => env('MENTIONME_BASE_URL', 'https://api.mention-me.com/api/v2'),
];
