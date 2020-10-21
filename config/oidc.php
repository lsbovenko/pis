<?php

return [
    'url' => env('OIDC_URL'),
    'client_id' => env('OIDC_CLIENT_ID'),
    'client_secret' => env('OIDC_CLIENT_SECRET'),
    'session_lifetime' => env('OIDC_SESSION_LIFETIME', 5), //5 min
];
