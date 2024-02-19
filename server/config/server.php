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

return [
    // 监听的协议 ip 及端口 （可选）
    'listen' => getenv('SERVER_LISTEN'),
    // transport (可选，当需要开启ssl时设置为ssl，默认为tcp)
    'transport' => 'tcp',
    // context （可选，当transport为是ssl时，需要传递证书路径）
    'context' => [],
    'name' => 'webman',
    // 进程数 （可选，默认1）
    'count' => cpu_count() * 4,
    // 进程运行用户 （可选，默认当前用户）
    'user' => '',
    // 进程运行用户组 （可选，默认当前用户组）
    'group' => '',
    // 是否开启reusePort （可选，此选项需要php>=7.0，默认为true）
    'reusePort' => true,
    //轮询模式 默认为空则是 IO多路复用模式 多进程阻塞模式 , 每个进程维护一条mysql链接
    //相关资料 https://segmentfault.com/a/1190000039377021?sort=votes
    //加入php swoole扩展(windows不支持)后可以设置为 \Workerman\Events\Swoole 协程 异步非阻塞模式,但是这种模式数据库部分需要考虑采用mysql连接池方案，否则并发下链接可能被占用
    //链接不够和进程占用过久考虑从下方案选择 优先第一个方案
    //1.链接不够和进程占用过久 慢链接方案 https://www.workerman.net/doc/webman/others/task.html https://www.workerman.net/q/9067
    //2.连接池解决方案 新建一个进程专门负责sql查询，sql操作丢给该进程查询和返回 https://www.workerman.net/q/391
    'event_loop' => '',
    'stop_timeout' => 2,
    'pid_file' => runtime_path() . '/webman.pid',
    'status_file' => runtime_path() . '/webman.status',
    'stdout_file' => runtime_path() . '/logs/stdout.log',
    'log_file' => runtime_path() . '/logs/workerman.log',
    'max_package_size' => 10 * 1024 * 1024
];
