<?php

use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../support/bootstrap.php';

if (PHP_SAPI === 'cli') {
    $config = config('server');
    Worker::$pidFile = $config['pid_file'];
    Worker::$stdoutFile = $config['stdout_file'];
    Worker::$logFile = $config['log_file'];
    Worker::$eventLoopClass = $config['event_loop'] ?? '';
}