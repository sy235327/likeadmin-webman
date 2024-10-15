<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Session\FileSessionHandler;
use Webman\Session\RedisSessionHandler;
use Webman\Session\RedisClusterSessionHandler;

$type = "file";
$sessionHandler = FileSessionHandler::class;
switch (getenv('SESSION_DRIVER')) {
    case 'redis':
        $type = 'redis';
        $sessionHandler = RedisSessionHandler::class;
        break;
    case 'redis_cluster':
        $type = 'redis_cluster';
        $sessionHandler = RedisClusterSessionHandler::class;
        break;
}
return [

    'type' => $type, // file or redis or redis_cluster

    'handler' => $sessionHandler,

    'config' => [
        'file' => [
            'save_path' => runtime_path() . '/sessions',
        ],
        'redis' => [
            'auth' => '',
            'timeout' => 2,
            'type' => 'redis',
            'host' => getenv('REDIS_HOST'),
            'password' => getenv('REDIS_PASSWORD'),
            'port' => getenv('REDIS_PORT'),
            'database' => getenv('REDIS_DB'),
            'prefix' => getenv('CACHE_SESSION_PREFIX'),
        ],
        'redis_cluster' => [
            'host' => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7001'],
            'timeout' => 2,
            'auth' => '',
            'prefix' => getenv('CACHE_SESSION_PREFIX'),
        ]
    ],

    'session_name' => 'PHPSID',
    
    'auto_update_timestamp' => false,

    'lifetime' => 7*24*60*60,

    'cookie_lifetime' => 365*24*60*60,

    'cookie_path' => '/',

    'domain' => '',
    
    'http_only' => true,

    'secure' => false,
    
    'same_site' => '',

    'gc_probability' => [1, 1000],

];
