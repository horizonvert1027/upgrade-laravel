<?php

return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => 1500000,
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => storage_path('framework/sessions'),

    'connection' => null,
    'table' => 'sessions',
    'store' => null,

    'lottery' => [2, 100],
    'cookie' => 'session',
    'path' => '/',
    'domain' => null,
    'secure' => true,
    'http_only' => true,

];
