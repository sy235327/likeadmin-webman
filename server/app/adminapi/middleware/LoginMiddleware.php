<?php


namespace app\adminapi\middleware;


use app\adminapi\service\AdminTokenService;
use app\common\cache\AdminTokenCache;
use app\common\service\JsonService;
use Closure;
use Webman\Config;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class LoginMiddleware implements  MiddlewareInterface
{

    /**
     * @notes 登录验证
     * @param $request
     * @param Closure $next
     * @author 乔峰
     * @date 2021/7/1 17:33
     */
    public function process(Request $request, callable $handler): Response
    {
        $token = $request->header('token','');
        $controllerObject = make($request->controller);
        //判断接口是否免登录
        $isNotNeedLogin = $controllerObject->isNotNeedLogin($request->action);

        //不直接判断$isNotNeedLogin结果，使不需要登录的接口通过，为了兼容某些接口可以登录或不登录访问
        if (empty($token) && !$isNotNeedLogin) {
            //没有token并且该地址需要登录才能访问
            return JsonService::fail('请求参数缺token', [], 0, 0);
        }

        $adminInfo = (new AdminTokenCache())->getAdminInfo($token);
        if (empty($adminInfo) && !$isNotNeedLogin) {
            //token过期无效并且该地址需要登录才能访问
            return JsonService::fail('登录超时，请重新登录', [], -1);
        }

        //token临近过期，自动续期
        if ($adminInfo) {
            //获取临近过期自动续期时长
            $beExpireDuration = Config::get('project.admin_token.be_expire_duration');
            //token续期
            if (time() > ($adminInfo['expire_time'] - $beExpireDuration)) {
                $result = AdminTokenService::overtimeToken($token);
                //续期失败（数据表被删除导致）
                if (empty($result)) {
                    return JsonService::fail('登录过期', [], -1);
                }
            }
        }

        //给request赋值，用于控制器
        $adminId = $adminInfo['admin_id'] ?? 0;
        if (!$adminInfo){
            $adminInfo = [];
        }
        $controllerObject->setAdmin($adminId,$adminInfo);
        return $handler($request);
    }
}