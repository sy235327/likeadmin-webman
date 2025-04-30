<?php

return [
    'default' => getenv('DB_CONNECTION','mysql'),
    'connections' => [
        'mysql'=>[
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => getenv('DB_HOST'),
            // 数据库名
            'database' => getenv('DB_DATABASE'),
            // 数据库用户名
            'username' =>  getenv('DB_USERNAME'),
            // 数据库密码
            'password' =>  getenv('DB_PASSWORD'),
            // 数据库连接端口
            'hostport' =>  getenv('DB_PORT'),
            // 数据库连接参数
            'params' => [
                // 连接超时3秒
                \PDO::ATTR_TIMEOUT => 3,
            ],
            // 数据库编码默认采用utf8
            'charset' => 'utf8',
            // 数据库表前缀
            'prefix' => getenv('DB_PREFIX'),
            // 断线重连
            'break_reconnect' => true,
            // 关闭SQL监听日志
            'trigger_sql' => getenv('SQL_DEBUG',false),
            // 自定义分页类
            'bootstrap' =>  '',
            //时间字段的自动处理是框架提供的实现时间字段（包括create_time和update_time，支持自定义字段名）的自动写入和自动输出转换功能。
            // 自动写入时间戳字段
            // true为自动识别类型 false关闭
            // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
            'auto_timestamp' => true,
            // 时间字段取出后的默认时间格式
            'datetime_format' => false,
            // 连接池配置
            'pool' => [
                'max_connections' => 5, // 最大连接数
                'min_connections' => 1, // 最小连接数
                'wait_timeout' => 3,    // 从连接池获取连接等待超时时间
                'idle_timeout' => 60,   // 连接最大空闲时间，超过该时间会被回收
                'heartbeat_interval' => 50, // 心跳检测间隔，需要小于60秒
            ],
        ]
    ],
];
