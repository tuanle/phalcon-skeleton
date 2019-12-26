<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    */

    'default' => env('MAIL_DRIVER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | MAIL DRIVERS
    |
    */

    'drivers' => [
        'smtp' => [
            'driver' => env('MAIL_DRIVER', 'smtp'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'from' => [
                'email' => env('MAIL_FROM_ADDRESS'),
                'name' => env('MAIL_FROM_NAME'),
            ],
            'encryption' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'cc' => env('MAIL_CC_ADDRESS'),
        ],
    ],
];
