<?php
return [
    'default' => 'redis',
    'stores' => [
        'file' => [
            'type' => 'File',
            // 缓存保存目录
            'path' => runtime_path() . '/cache/',
            // 缓存前缀
            'prefix' => '',
            // 缓存有效期 0表示永久缓存
            'expire' => 0,
        ],
        'redis' => [
            'type' => 'redis',
            'host' => getenv('REDIS_HOST'),
            'password' => getenv('REDIS_PASSWORD'),
            'port' => getenv('REDIS_PORT'),
            'database' => getenv('REDIS_DB'),
            'prefix' => getenv('CACHE_PREFIX'),
            'expire' => 0,
        ],
    ],
];