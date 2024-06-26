<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете указать диск файловой системы по умолчанию, который должен использоваться платформой
    |. Для вашего приложения доступны как "локальный" диск, так и различные облачные диски
    |. Просто сохраните его!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете настроить столько "дисков" файловой системы, сколько пожелаете, и вы
    | можете даже настроить несколько дисков для одного и того же драйвера. Для каждого драйвера были установлены значения по умолчанию
    | в качестве примера требуемых значений.
    |
    | Поддерживаемые драйверы: "local", "ftp", "sftp", "s3"
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете настроить символьные ссылки, которые будут созданы при
    выполнении команды Artisan
    | `storage:link". Ключами массива должны быть
    | местоположения ссылок, а значения - их целевыми объектами.    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
