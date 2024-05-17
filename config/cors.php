<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
| Здесь вы можете настроить параметры для совместного использования ресурсов из разных источников
    | или "CORS". Это определяет, какие операции из разных источников могут выполняться
    | в веб-браузерах. Вы можете изменять эти параметры по мере необходимости.
    |
    | Чтобы узнать больше: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
