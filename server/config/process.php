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

use app\crontab\Task;
use Workerman\Worker;
//慢进程，nginx反向代理部分需要慢执行的路由到TASK_LISTEN的端口进程执行解决堵塞问题
//https://www.workerman.net/doc/webman/others/task.html
$task = [
    'name' => 'name',
    'handler' => \Webman\App::class,
    'listen' => getenv('SLOW_SERVER_LISTEN'),
    'count' => 8, // 进程数
    'user' => '',
    'group' => '',
    'reusePort' => true,
    'constructor' => [
        'request_class' => \support\Request::class, // request类设置
        'logger' => \support\Log::channel('default'), // 日志实例
        'app_path' => app_path(), // app目录位置
        'public_path' => public_path() // public目录位置
    ]
];
/**
 * crontab并不是异步的，例如一个task进程里设置了A和B两个定时器，都是每秒执行一次任务，但是A任务耗时10秒，那么B需要等待A执行完才能被执行，导致B执行会有延迟。
 *     'task1'  => [
 *     'handler'  => process\Task1::class
 *     ],
 *     'task2'  => [
 *     'handler'  => process\Task2::class
 *     ],
 * https://www.workerman.net/doc/webman/components/crontab.html
 */
$crontabs = [
    'crontab'=>[
        'handler' => Task::class
    ]
];
$returnData = [
    // File update detection and automatic reload
    'monitor' => [
        'handler' => process\Monitor::class,
        'reloadable' => false,
        'constructor' => [
            // Monitor these directories
            'monitor_dir' => array_merge([
                app_path(),
                config_path(),
                base_path() . '/process',
                base_path() . '/support',
                base_path() . '/other_resource',
                base_path() . '/.env',
            ], glob(base_path() . '/plugin/*/app'), glob(base_path() . '/plugin/*/config'), glob(base_path() . '/plugin/*/api')),
            // Files with these suffixes will be monitored
            'monitor_extensions' => [
                'php', 'html', 'htm', 'env'
            ],
            'options' => [
                'enable_file_monitor' => !Worker::$daemonize && DIRECTORY_SEPARATOR === '/',
                'enable_memory_monitor' => DIRECTORY_SEPARATOR === '/',
            ]
        ]
    ],
];
if (getenv('SLOW_PROCESS_STATUS',false)){
    $returnData['slow_process'] = $task;
}
if (getenv('CRONTAB_STATUS',false)){
    foreach ($crontabs as $crontabKey=>$crontab){
        $returnData[$crontabKey] = $crontab;
    }
}
return $returnData;
