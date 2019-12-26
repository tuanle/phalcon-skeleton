<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    */

    'default' => env('FILESYSTEM_DRIVER', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |
    */

    'disks' => [

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],

    'images' => [
        'cloud_front' => [
            'host' => env('CLOUD_FRONT_HOST', ''),
        ],
    ]

];
