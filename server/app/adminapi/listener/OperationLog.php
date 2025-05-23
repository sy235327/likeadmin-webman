<?php


namespace app\adminapi\listener;


use app\adminapi\controller\BaseAdminController;
use app\api\controller\BaseApiController;
use ReflectionClass;
use ReflectionException;
use support\Log;
use Webman\Http\Request;
use think\Exception;
use Webman\Http\Response;

class OperationLog
{
    /**
     * @notes 管理员操作日志
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws ReflectionException
     * @author bingo
     * @date 2022/4/8 17:09
     */
    public static function handle(Request $request, Response $response): mixed
    {
        $controllerObject = make($request->controller);
        if (!$controllerObject){
            return false;
        }
        if ($controllerObject instanceof BaseAdminController) {
            return self::handleAdmin($controllerObject, $request, $response);
        }
        if ($controllerObject instanceof BaseApiController) {
            return self::handleUser($controllerObject, $request, $response);
        }
        return true;
    }
    public static function handleAdmin($controllerObject, Request $request, Response $response): mixed{
        [$adminId,$adminInfo] = $controllerObject->getAdmin();

        //需要登录的接口，无效访问时不记录
        if (!$controllerObject->isNotNeedLogin($request->action) && empty($adminInfo)) {
            return false;
        }
        $pathLower = strtolower($request->path());
        //不记录日志操作
        if ($pathLower === '/adminapi/setting/system/log') {
            return false;
        }

        //获取操作注解
        $notes = '无法获取操作名称，请给控制器方法注释';
        try {
            $re = new ReflectionClass($controllerObject);
            $doc = $re->getMethod($request->action)->getDocComment();
            if (empty($doc)) {
                throw new Exception('请给控制器方法注释');
            }
            preg_match('/\s(\w+)/u', $re->getMethod($request->action)->getDocComment(), $values);
            $notes = $values[0];
        } catch (Exception $e) {
            Log::error("日志记录错误",[
                'path'=>$request->path(),
                'title'=>"无法获取操作名称，请给控制器方法注释",
                'msg'=>$e->getMessage(),
            ]);
        }

        $params = $request->all();

        //过滤密码参数
        if (isset($params['password'])) {
            $params['password'] = "******";
        }
        //过滤密钥参数
        if(isset($params['app_secret'])){
            $params['app_secret'] = "******";
        }

        //导出数据操作进行记录
        if (isset($params['export']) && $params['export'] == 2) {
            $notes .= '-数据导出';
        }
        //记录日志
        $systemLog = new \app\common\model\OperationLog();
        $systemLog->admin_id = $adminInfo['admin_id'] ?? 0;
        $systemLog->admin_name = $adminInfo['name'] ?? '';
        $systemLog->action = $notes;
        $systemLog->account = $adminInfo['account'] ?? '';
        $systemLog->url = $request->path();
        $systemLog->type = $request->method();
        $systemLog->params = json_encode($params, true);
        $systemLog->ip = getRealIP();
        $systemLog->result = 0;
        // 正则表达式匹配指定key的值
        preg_match('/"code":\s*"([^"]+)"/', $response->rawBody(), $matches);
        if (isset($matches[1])) {
            $systemLog->result = $matches[1];
        }
        $res = $systemLog->save();
        Log::info("日志记录",[
            'id'=>$systemLog->id,
            'adminId'=>$systemLog->admin_id,
            'url'=>$systemLog->url,
            'params'=>$systemLog->params,
            'result'=>$response->rawBody(),
        ]);
        return $res;
    }
    public static function handleUser($controllerObject, Request $request, Response $response): mixed{
        return true;
    }
}