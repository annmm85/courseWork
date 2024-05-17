<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
      |--------------------------------------------------------------------------
      | Название приложения
      |--------------------------------------------------------------------------
      |
      | Это значение является именем вашего приложения. Это значение используется, когда
  | framework необходимо поместить название приложения в уведомление или
      | в любое другое место, требуемое приложением или его пакетами.
      |
      */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | Это значение определяет "среду", в которой в данный момент работает ваше приложение
    |. Это может определять, как вы предпочитаете настраивать различные
    | службы, используемые приложением. Задайте это в своем файле ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Прикладная среда
    |--------------------------------------------------------------------------
    |
    | Это значение определяет "среду", в которой в данный момент работает ваше приложение
    |. Это может определять, как вы предпочитаете настраивать различные
    | службы, используемые приложением. Задайте это в своем файле ".env".
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL-адрес приложения
    |--------------------------------------------------------------------------
    |
    | Этот URL-адрес используется консолью для правильной генерации URL-адресов при использовании
    | инструмента командной строки Artisan. Вам следует указать его в корневом
    каталоге | вашего приложения, чтобы он использовался при выполнении задач Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', '/'),

    /*
    |--------------------------------------------------------------------------
    | Часовой пояс приложения
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете указать часовой пояс по умолчанию для вашего приложения, который
    | будет использоваться функциями даты и времени PHP. Мы перешли
    | вперед и установите для этого значения разумное значение по умолчанию "из коробки".
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Конфигурация языкового стандарта приложения
    |--------------------------------------------------------------------------
    |
    | Языковой стандарт приложения определяет языковой стандарт по умолчанию, который будет использоваться
    | поставщиком услуг перевода. Вы можете свободно устанавливать это значение
    | в любой из языков, которые будут поддерживаться приложением.
    |
    */

    'locale' => 'en',

    /*
        |--------------------------------------------------------------------------
        | Резервный язык приложения
        |--------------------------------------------------------------------------
        |
        | Резервный языковой стандарт определяет языковой стандарт, который будет использоваться, если текущий
        | недоступен. Вы можете изменить это значение, чтобы оно соответствовало любой из
        | языковых папок, предоставляемых вашим приложением.
        |
        */

    'fallback_locale' => 'en',

    /*
        |--------------------------------------------------------------------------
        | Место действия мошенника
        |--------------------------------------------------------------------------
        |
        | Этот языковой стандарт будет использоваться библиотекой Faker PHP при создании поддельных
        | данных для вашей базы данных seeds. Например, это будет использоваться для получения
        | локализованных телефонных номеров, информации об адресах улиц и многого другого.
        |
        */

    'faker_locale' => 'en_US',

    /*
            |--------------------------------------------------------------------------
            | Ключ шифрования
            |--------------------------------------------------------------------------
            |
            | | Этот ключ используется службой Illuminate encrypter и должен быть установлен
            | в случайную строку из 32 символов, в противном случае эти зашифрованные строки
            | будут небезопасны. Пожалуйста, сделайте это перед развертыванием приложения!
            |
        */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
        |--------------------------------------------------------------------------
        | Драйвер режима технического обслуживания
        |--------------------------------------------------------------------------
        |
        | Эти параметры конфигурации определяют драйвер, используемый для определения
    состояния "режима обслуживания" Laravel и | | управления им. Драйвер "кэш"
        | позволяет управлять режимом обслуживания на нескольких компьютерах.
        |
        | Поддерживаемые драйверы: "файл", "кэш"
        |
        */
    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
        |--------------------------------------------------------------------------
        | | Поставщики услуг автозагрузки
        |--------------------------------------------------------------------------
        |
        | Перечисленные здесь поставщики услуг будут автоматически загружены в
        | запрос к вашему приложению. Не стесняйтесь добавлять свои собственные сервисы в
        | этот массив, чтобы предоставить расширенную функциональность вашим приложениям.
        |
        */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
        |--------------------------------------------------------------------------
        | Псевдонимы классов
        |--------------------------------------------------------------------------
        |
        | Этот массив псевдонимов классов будет зарегистрирован при запуске этого приложения
        |. Однако вы можете регистрировать их сколько угодно, поскольку
        | псевдонимы загружаются "лениво", поэтому они не снижают производительность.
        |
        */

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

];
