<?php

namespace app\queue\redis;

use app\queue\send\SendQueue;
use Webman\RedisQueue\Consumer;

class MySendMail implements Consumer
{
    /**
     * 队列和配置初始化
     */
    public function __construct() {
        $this->connection = getenv('REDIS_QUEUE_CONNECTION');
        $this->queue = SendQueue::$QUEUE_LOG_PUSH;
    }

    // 要消费的队列名
    public $queue = '';

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public $connection = '';


    // 消费
    public function consume($data)
    {
        // 无需反序列化
        var_export($data);
    }
    // 消费失败回调
    /*
    $package = [
        'id' => 1357277951, // 消息ID
        'time' => 1709170510, // 消息时间
        'delay' => 0, // 延迟时间
        'attempts' => 2, // 消费次数
        'queue' => 'send-mail', // 队列名
        'data' => ['to' => 'tom@gmail.com', 'content' => 'hello'], // 消息内容
        'max_attempts' => 5, // 最大重试次数
        'error' => '错误信息' // 错误信息
    ]
    */
    public function onConsumeFailure(\Throwable $e, $package)
    {
        echo "consume failure\n";
        echo $e->getMessage() . "\n";
        // 无需反序列化
        var_export($package);
    }
}
