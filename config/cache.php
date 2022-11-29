<?php

return [
    'default' => env('CACHE_DRIVER', 'redis'),
    'stores' => [
        'apc' => [
            'driver' => 'apc',
        ],
        'array' => [
            'driver' => 'array',
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
        ],
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache'),
        ],
        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl'       => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options'    => [
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],
        'redis' => [
   'client' => 'predis',
   'default' => [
       'host' => env('REDIS_HOST', 'localhost'),
       'password' => env('REDIS_PASSWORD', null),
       'port' => env('REDIS_PORT', 6379),
       'database' => 0,
   ],
],
    ],
    'prefix' => 'laravel',
];
