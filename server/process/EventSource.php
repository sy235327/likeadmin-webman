<?php
namespace process;

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\ServerSentEvents;
use Workerman\Protocols\Http\Response;
use Workerman\Timer;

/**
 * SSE响应示例
 *
 * 客户端示例:
 * var source = new EventSource('http://127.0.0.1:8686');
 * source.addEventListener('message', function (event) {
 * var data = event.data;
 * console.log(data); // 输出 hello
 * }, false);
 */
class EventSource
{
    public function onMessage(TcpConnection $connection, Request $request)
    {
        // 如果Accept头是text/event-stream则说明是SSE请求
        if ($request->header('accept') === 'text/event-stream') {
            // 首先发送一个 Content-Type: text/event-stream 头的响应
            $connection->send(new Response(200, ['Content-Type' => 'text/event-stream']));
            // 定时向客户端推送数据
            $timer_id = Timer::add(2, function () use ($connection, &$timer_id){
                // 连接关闭的时候要将定时器删除，避免定时器不断累积导致内存泄漏
                if ($connection->getStatus() !== TcpConnection::STATUS_ESTABLISHED) {
                    Timer::del($timer_id);
                    return;
                }
                // 发送message事件，事件携带的数据为hello，消息id可以不传
                $connection->send(new ServerSentEvents(['event' => 'message', 'data' => 'hello', 'id'=>1]));
            });
            return;
        }
        $connection->send('ok');
    }
}