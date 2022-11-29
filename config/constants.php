<?php

return[
    'cache' => [
        'urls' => [
            'photo' => 'photo/*',
            // 'file' => 'file/*',
            'category' => 'c/*',
            'subcategory' => 's/*',
            'subgroup' => 'g/*',
            'latest' => 'latest',
            'home' => '/',
            'featured' => 'featured',
            'fetch' => 'fetch/*',
            // 'search' => 'search?q=*',
        ],
        'time' => env('CACHE_TIME', '0'), //day
        'is_active' =>  env('PAGE_CACHE', '0') //0 to disable 1 to activate
    ]
];
