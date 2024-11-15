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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use think\exception\ClassNotFoundException;
use Webman\App;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;


class InitMiddleware implements MiddlewareInterface
{

    /**
     * @notes 初始化
     * @return mixed
     * @throws ControllerExtendException
     * @throws HttpException
     * @author suyi
     * @date 2024/11/15
     */
    public function process(Request $request, callable $handler): Response
    {
        //获取控制器
        try {
            $plugin = $request->plugin ?: '';
            $controllerClass = App::container($plugin)->get($request->controller);
            if (($controllerClass instanceof BaseApiController) === false) {
                throw new ControllerExtendException($request->controller, '404');
            }
            //创建控制器对象
            $request->controllerObject = $controllerClass;
        } catch (ClassNotFoundException $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getClass());
        } catch (NotFoundExceptionInterface $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getMessage());
        }
        return $handler($request);
    }
}