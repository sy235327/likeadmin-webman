<?php


namespace app\adminapi\listener;


use ReflectionClass;
use support\Log;
use Webman\Http\Request;
use think\Exception;
use Webman\Http\Response;

class OperationLog
{
    /**
     * @notes 管理员操作日志
     * @param $response
     * @return bool
     * @throws \ReflectionException
     * @author bingo
     * @date 2022/4/8 17:09
     */
    public static function handle(Request $request, Response $response)
    {
        //需要登录的接口，无效访问时不记录
        if (!$request->controllerObject||!$request->controllerObject->isNotNeedLogin($request->action) && empty($request->adminInfo)) {
            return false;
        }
        $pathLower = strtolower($request->path());
        //不记录日志操作
        if (str_contains($pathLower,"/api/")||$pathLower === '/adminapi/setting/system/log') {
            return false;
        }

        //获取操作注解
        $notes = '';
        try {
            $re = new ReflectionClass($request->controllerObject);
            $doc = $re->getMethod($request->action)->getDocComment();
            if (empty($doc)) {
                throw new Exception('请给控制器方法注释');
            }
            preg_match('/\s(\w+)/u', $re->getMethod($request->action)->getDocComment(), $values);
            $notes = $values[0];
        } catch (Exception $e) {
            $notes = $notes ?: '无法获取操作名称，请给控制器方法注释';
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
        \app\common\model\OperationLog::destroy(function ($query) {
            $query->where('create_time','<',strtotime("-15 day"));
        },true);
        //记录日志
        $systemLog = new \app\common\model\OperationLog();
        $systemLog->admin_id = $request->adminInfo['admin_id'] ?? 0;
        $systemLog->admin_name = $request->adminInfo['name'] ?? '';
        $systemLog->action = $notes;
        $systemLog->account = $request->adminInfo['account'] ?? '';
        $systemLog->url = $request->path();
        $systemLog->type = $request->method();
        $systemLog->params = json_encode($params, true);
        $systemLog->ip = getRealIP();
        $result = 0;
        // 正则表达式匹配指定key的值
        preg_match('/"code":\s*"([^"]+)"/', $response->rawBody(), $matches);
        if (isset($matches[1])) {
            $result = $matches[1];
        }
        $systemLog->result = $result;
        $res = $systemLog->save();
        Log::info("SystemLog id=".$systemLog->id.
            ' adminId='.$systemLog->admin_id.
            ' 请求地址:`'.$systemLog->url.'`'.
            ' 请求参数:`'.$systemLog->params."`".
            ' 返回结果:`'.$response->rawBody()."`");
        return $res;
    }
}