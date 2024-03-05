<?php
return [
    'default' => [
        'host' => 'redis://'.getenv('REDIS_QUEUE_CONNECTION','127.0.0.1').':'.getenv('REDIS_QUEUE_PORT','6379'),
        'options' => [
            'auth' => getenv('REDIS_QUEUE_PASSWORD',null),       // 密码，字符串类型，可选参数
            'db' => getenv('REDIS_QUEUE_DB',0),            // 数据库
            'prefix' => getenv('REDIS_QUEUE_PREFIX',''),       // key 前缀
            'max_attempts'  => 5, // 消费失败后，重试次数
            'retry_seconds' => 5, // 重试间隔，单位秒
        ]
    ],
];
