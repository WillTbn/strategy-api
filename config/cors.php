<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

<<<<<<< HEAD
    'allowed_origins' => ['http://localhost:9010', 'https://test.strategyanalytics.com.br', 'https://strategyanalytics.com.br'],
=======
    'allowed_origins' => ['http://localhost:9010', 'https://test.strategyanalytics.com.br', '.strategyanalytics.com.br'],
>>>>>>> 6f3b2a1ca3314c1627f8e33ee1d2bf3a4c6a585f

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
