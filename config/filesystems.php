<?php
return [
    'default' => env('FILESYSTEM_DRIVER', 'default'),
    'cloud' => env('FILESYSTEM_CLOUD', 's3'),
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'options' => [ 'visibility' => 'public', 'CacheControl' => 'max-age=31536000'],
        ],

        'default' => [
             'driver' => 'local',
             'root' => public_path(),
             'url' => env('APP_URL').'/public',
             'visibility' => 'public',
        ],

        'dospace' => [
          'driver' => 's3',
          'key' => env('DOS_ACCESS_KEY_ID'),
          'secret' => env('DOS_SECRET_ACCESS_KEY'),
          'region' => env('DOS_DEFAULT_REGION'),
          'bucket' => env('DOS_BUCKET'),
          'endpoint' => 'https://'.env('DOS_DEFAULT_REGION').'.digitaloceanspaces.com',
          'options' => [ 'visibility' => 'public', 'CacheControl' => 'max-age=31536000' ],
        ],

        'wasabi' => [
          'driver' => 's3',
          'key' => env('WAS_ACCESS_KEY_ID'),
          'secret' => env('WAS_SECRET_ACCESS_KEY'),
          'region' => env('WAS_DEFAULT_REGION'),
          'bucket' => env('WAS_BUCKET'),
          'endpoint' => 'https://s3.'.env('WAS_DEFAULT_REGION').'.wasabisys.com'
        ],
    ],

];
