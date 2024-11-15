<?php


namespace app\adminapi\middleware;


use app\common\cache\AdminAuthCache;
use app\common\service\JsonService;
use think\helper\Str;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        //不登录访问，无需权限验证
        if ($request->controllerObject->isNotNeedLogin($request->action)) {
            return $handler($request);
        }

        //系统默认超级管理员，无需权限验证
        if (1 === $request->adminInfo['root']) {
            return $handler($request);
        }

        $adminAuthCache = new AdminAuthCache($request->adminInfo['admin_id']);

        // 当前访问路径
        $accessUri = strtolower($request->controller . '/' . $request->action);
        // 全部路由
        $allUri = $this->formatUrl($adminAuthCache->getAllUri());

        // 判断该当前访问的uri是否存在，不存在无需验证
        if (!in_array($accessUri, $allUri)) {
            return $handler($request);
        }

        // 当前管理员拥有的路由权限
        $AdminUris = $adminAuthCache->getAdminUri() ?? [];
        $AdminUris = $this->formatUrl($AdminUris);

        if (in_array($accessUri, $AdminUris)) {
            return $handler($request);
        }
        return JsonService::fail('权限不足，无法访问或操作');
    }

    /**
     * @notes 格式化URL
     * @param array $data
     * @return array|string[]
     * @author 乔峰
     * @date 2022/7/7 15:39
     */
    public function formatUrl(array $data)
    {
        return array_map(function ($item) {
            return strtolower(Str::camel($item));
        }, $data);
    }
}