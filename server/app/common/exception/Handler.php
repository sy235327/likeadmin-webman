<?php


namespace app\common\exception;

use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * 不用记录日志的异常
     * @var string[]
     */
    public $dontReport = [
        HttpException::class
    ];

    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    public function render(Request $request, Throwable $exception) : Response
    {
        if ($exception instanceof HttpException) {
            return $exception->getResponse();
        }
        if ($request->expectsJson()) {
            $msg = '服务器错误!';
            if (getenv('APP_DEBUG',false)) {
                $msg = $exception->getMessage();
            }
            $json = ['code' => 0, 'msg' => $msg, 'show' => 1];
            return new Response(200, ['Content-Type' => 'application/json'],
                json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        return parent::render($request, $exception);
    }
}