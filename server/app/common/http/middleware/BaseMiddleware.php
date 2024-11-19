<?php
// +----------------------------------------------------------------------
// | likeadmin快速开发前后端分离管理后台（PHP版）
// +----------------------------------------------------------------------
// | 欢迎阅读学习系统程序代码，建议反馈是我们前进的动力
// | 开源版本可自由商用，可去除界面版权logo
// | gitee下载：https://gitee.com/likeshop_gitee/likeadmin
// | github下载：https://github.com/likeshop-github/likeadmin
// | 访问官网：https://www.likeadmin.cn
// | likeadmin团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | author: likeadminTeam
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\common\http\middleware;

use app\adminapi\listener\OperationLog;
use Closure;
use Exception;
use Fiber;
use support\Log;
use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

/**
 * 基础中间件
 * Class LikeShopMiddleware
 * @package app\common\http\middleware
 */
class BaseMiddleware implements MiddlewareInterface
{

    public function process(Request $request, callable $handler): Response
    {
        $response = $handler($request);
        //创建一个纤程任务记录日志
        try{
            $fiber = (new Fiber(function() use ($request, $response): void{
                OperationLog::handle($request,$response);
            }));
            $fiber->start();
        }catch (Exception|Throwable $e){
            Log::error('请求日志记录失败:'.$e->getMessage());
        }
        return $response;
    }
}