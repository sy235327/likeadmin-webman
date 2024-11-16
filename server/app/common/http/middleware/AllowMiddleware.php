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
use Fiber;
use support\Log;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

/**
 * 自定义跨域中间件
 * Class LikeAdminAllowMiddleware
 * @package app\common\http\middleware
 */
class AllowMiddleware implements MiddlewareInterface
{
    /**
     * Notes: 跨域处理
     * Date: 2023/2/27下午3:46
     * @param Request $request
     * @param callable $handler
     * @return Response
     */

    public function process(Request $request, callable $handler): Response
    {
        // 如果是opitons请求则返回一个空的响应，否则继续向洋葱芯穿越，并得到一个响应
        $response = null;
        if ($request->method() == 'OPTIONS'){
            $response = response('');
        }else{
            $response = $handler($request);
            //创建一个纤程任务记录日志
            try{
                $fiber = (new Fiber(function() use ($request, $response): void{
                    OperationLog::handle($request,$response);
                }));
                $fiber->start();
            }catch (\Exception|\Throwable $e){
                Log::error('请求日志记录失败:'.$e->getMessage());
            }
        }

        // 给响应添加跨域相关的http头
        $response->withHeaders([
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => $request->header('origin', '*'),
            'Access-Control-Allow-Methods' => $request->header('access-control-request-method', '*'),
            'Access-Control-Allow-Headers' => $request->header('access-control-request-headers', '*'),
            'Access-Control-Expose-Headers'=>'*'
        ]);
        return $response;
    }
}