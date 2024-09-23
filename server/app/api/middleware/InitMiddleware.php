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

namespace app\api\middleware;


use app\api\controller\BaseApiController;
use app\common\exception\ControllerExtendException;
use app\common\exception\HttpException;
use think\exception\ClassNotFoundException;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;


class InitMiddleware implements MiddlewareInterface
{

    /**
     * @notes 初始化
     * @return mixed
     * @throws ControllerExtendException
     * @author 段誉
     * @date 2022/9/6 18:17
     */
    public function process(Request $request, callable $handler): Response
    {
        $controllerClass = null;
        //获取控制器
        try {
            $controller = str_replace('.', '\\', $request->controller);
            $controllerClass = new $controller;
            if (($controllerClass instanceof BaseApiController) === false) {
                throw new ControllerExtendException($controller, '404');
            }
        } catch (ClassNotFoundException $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getClass());
        }
        //创建控制器对象
        $request->controllerObject = $controllerClass;
        return $handler($request);
    }
}