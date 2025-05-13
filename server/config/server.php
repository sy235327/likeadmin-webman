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

use Workerman\Events\Fiber;

return [
    // 监听的协议 ip 及端口 （可选）
    'listen' => getenv('SERVER_LISTEN'),
    // transport (可选，当需要开启ssl时设置为ssl，默认为tcp)
    'transport' => 'tcp',
    // context （可选，当transport为是ssl时，需要传递证书路径）
    'context' => [],
    'name' => 'webman',
    // 进程数 （可选，默认1）
    'count' => cpu_count()*4,
    // 进程运行用户 （可选，默认当前用户）
    'user' => '',
    // 进程运行用户组 （可选，默认当前用户组）
    'group' => '',
    // 是否开启reusePort （可选，此选项需要php>=7.0，默认为true）
    'reusePort' => true,
    //轮询模式 默认为空则是 IO多路复用模式 多进程阻塞模式 , 每个进程维护一条mysql链接
    //相关资料 https://segmentfault.com/a/1190000039377021?sort=votes
    //链接不够和进程占用过久 慢链接方案 https://www.workerman.net/doc/webman/others/task.html https://www.workerman.net/q/9067
    //Workerman\Events\Swoole; (需要开启swoole扩展,windows不支持) 协程 异步非阻塞模式,但是这种模式数据库部分需要考虑采用mysql连接池方案，否则并发下链接可能被占用,连接池解决方案 新建一个进程专门负责sql查询，sql操作丢给该进程查询和返回 https://www.workerman.net/q/391
    //Workerman\Events\Select; 它同时轮询数千个文件描述符的 IO 活动时(通常限制为 1024 个文件描述符的固定大小)  原生 PHP 在这方面的功能极限
    //Workerman\Events\Fiber; 如果您在严格的本地程序中使用该包以实现非阻塞并发，或者您不需要在服务器应用程序中处理超过几百个并发客户端，则php原生实现的Workerman\Events\Fiber应该足够了
    //Workerman\Events\Event;  (需要开启event扩展)为了实现横向扩展到高容量的性能，我们需要目前仅在扩展中发现的更高级功能,如果您希望在事件循环支持的套接字服务器中为 10,000 个并发客户端提供服务，则应使用基于 PHP 扩展的事件循环实现之一
    'event_loop' => Fiber::class,
    'stop_timeout' => 2,
    'pid_file' => runtime_path() . '/webman.pid',
    'status_file' => runtime_path() . '/webman.status',
    'stdout_file' => runtime_path() . '/logs/stdout.log',
    'log_file' => runtime_path() . '/logs/workerman.log',
    'max_package_size' => 10 * 1024 * 1024
];
