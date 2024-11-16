<?php


namespace app\adminapi\middleware;


use app\adminapi\controller\BaseAdminController;
use app\common\exception\ControllerExtendException;
use think\exception\ClassNotFoundException;
use app\common\exception\HttpException;
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
            //使用容器中的控制器对象
            $controllerClass = make($request->controller);
            if (($controllerClass instanceof BaseAdminController) === false) {
                throw new ControllerExtendException($request->controller, BaseAdminController::class);
            }
            $controllerClass->setAdmin(0,[]);
        } catch (ClassNotFoundException $e) {
            throw new HttpException($e->getMessage().' controller not exists:' . $e->getClass(),404);
        }
        return $handler($request);
    }
}