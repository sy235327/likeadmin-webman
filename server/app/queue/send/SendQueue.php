<?php
namespace app\queue\send;

use Webman\RedisQueue\Client;
use Webman\RedisQueue\Redis;

/**
 * 推送消息到队列
 */
class SendQueue
{
    public static string $QUEUE_LOG_PUSH = 'queue-send-mail';
    /**
     * 异步插入队列
     * @param $queue_name string 队列名
     * @param $data mixed 数据，可以直接传数组，无需序列化 例如：['to' => 'tom@gmail.com', 'content' => 'hello']
     * @param $delay int 0 是否投递延迟消息 延迟多少秒
     */
    public function queueAsync(string $queue_name,$data,int $delay = 0)
    {
        if ($delay === null){
            // 投递消息
            Client::send($queue_name, $data);
        }else{
            // 投递延迟消息，消息会在60秒后处理
            Client::send($queue_name, $data, $delay);
        }
    }
    /**
     * 同步插入队列
     * @param $queue_name string 队列名
     * @param $data mixed 数据，可以直接传数组，无需序列化 例如：['to' => 'tom@gmail.com', 'content' => 'hello']
     * @param $delay int 0 是否投递延迟消息 延迟多少秒
     * @return boolean 是否成功
     */
    public function queueSync(string $queue_name,$data,int $delay = 0)
    {
        if ($delay === null){
            // 投递消息
            return Redis::send($queue_name, $data);
        }else{
            // 投递延迟消息，消息会在60秒后处理
            return Redis::send($queue_name, $data, $delay);
        }
    }

}