<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => getenv('APP_NAME', 'phalcon'),

    /*
    |--------------------------------------------------------------------------
    | Application environment
    |--------------------------------------------------------------------------
    */
    'env' => getenv('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => env('APP_DEBUG', false),

    'debug_sql' => env('APP_DEBUG_SQL', false),

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    */
    'log_path' => BASE_PATH . '/storage/logs/phalcon.log',
    'sql_log_path' => BASE_PATH . '/storage/logs/sql.log',
    'sql_slow_log_path' => BASE_PATH . '/storage/logs/sql_slow.log',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    */
    'locale' => env('APP_LOCALE', 'ja'),

    'fallback_locale' => env('APP_LOCALE', 'ja'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */
    'key' => env('APP_KEY'),

    'cipher' => 'aes-256-ctr',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // Core
        \Support\Providers\MvcDispatcherServiceProvider::class,
        \Support\Providers\SessionServiceProvider::class,
        \Support\Providers\DatabaseServiceProvider::class,
        \Support\Providers\RequestServiceProvider::class,
        \Support\Providers\ResponseServiceProvider::class,
        \Support\Providers\ViewServiceProvider::class,
        \Support\Providers\AuthServiceProvider::class,
        \Support\Providers\SecurityServiceProvider::class,
        \Support\Providers\TranslationServiceProvider::class,
        \Support\Providers\FilesystemServiceProvider::class,
        \Support\Providers\UtilitiesServiceProvider::class,
        \Support\Providers\LoggingServiceProvider::class,
        \Support\Providers\DebuggingServiceProvider::class,

        // Application
        \App\Providers\AppServiceProvider::class,
        \App\Providers\RouterServiceProvider::class,
        \App\Providers\EventsServiceProvider::class,
    ],

    'cli_providers' => [
        \Support\Providers\CliDispatcherServiceProvider::class,
        \Support\Providers\SecurityServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Defines domains
    |--------------------------------------------------------------------------
    */
    'domains' => [
        'admin' => [
            'enabled' => env('DOMAIN_ADMIN_ENABLED', false),
            'host' => env('DOMAIN_ADMIN_HOST', 'admin.osouji.com'),
            'route' => \App\Routes\AdminRoute::class,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | View Configurations
    |--------------------------------------------------------------------------
    */
    'view' => [
        'autoescape' => true,
        'view_directory' => BASE_PATH . '/resources/views',
        'compiled_separator' => '_',
        'compiled_path' => BASE_PATH . '/storage/app/views/',
    ],

];
