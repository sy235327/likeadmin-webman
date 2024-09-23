<?php
namespace process;

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Chunk;
use Workerman\Protocols\Http\Response;
use Workerman\Timer;

/**
 * http-chunk
 * 访问 CHUNK_SERVER_LISTEN 页面会定时输出数据
 */
class HttpChunk
{
    public function onMessage(TcpConnection $connection, Request $request)
    {
        // 首先发送一个带Transfer-Encoding: chunked头的Response响应
        $total_count = 10;
        $connection->send(new Response(200, array('Transfer-Encoding' => 'chunked'), "共{$total_count}段数据<br>"));
        $timer_id = Timer::add(2, function () use ($connection, &$timer_id, $total_count){
            static $count = 0;
            // 连接关闭的时候要将定时器删除，避免定时器不断累积导致内存泄漏
            if ($connection->getStatus() !== TcpConnection::STATUS_ESTABLISHED) {
                Timer::del($timer_id);
                return;
            }
            if ($count++ >= $total_count) {
                // 发送一个空的''代表结束响应
                $connection->send(new Chunk(''));
                return;
            }
            // 发送chunk数据
            $connection->send(new Chunk("第{$count}段数据<br>"));
        });
    }
}