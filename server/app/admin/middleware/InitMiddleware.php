<?php


namespace app\admin\middleware;


use app\admin\controller\BaseAdminController;
use app\common\exception\ControllerExtendException;
use think\exception\ClassNotFoundException;
use app\common\exception\HttpException;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class InitMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $controllerClass = null;
        //获取控制器
        try {
            $controller = str_replace('.', '\\', $request->controller);
            $controllerClass = new $controller;
            if (($controllerClass instanceof BaseAdminController) === false) {
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