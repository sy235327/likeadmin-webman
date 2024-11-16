<?php


namespace app\common\controller;


use app\BaseController;
use app\common\lists\BaseDataLists;
use app\common\service\JsonService;
use support\Response;

class BaseLikeAdminController extends BaseController
{
    public array $notNeedLogin = [];

    /**
     * @notes 操作成功
     * @param string $msg
     * @param array $data
     * @param int $code
     * @param int $show
     * @return Response
     * @author 乔峰
     * @date 2021/12/27 14:21
     */
    protected function success(string $msg = 'success', array $data = [], int $code = 1, int $show = 0): Response
    {
        return JsonService::success($msg, $data, $code, $show);
    }


    /**
     * @notes 数据返回
     * @param $data
     * @return Response
     * @author 乔峰
     * @date 2021/12/27 14:21\
     */
    protected function data($data): Response
    {
        return JsonService::data($data);
    }


    /**
     * @notes 列表数据返回
     * @param BaseDataLists|null $lists
     * @author 令狐冲
     * @date 2021/7/8 00:40
     */
    protected function dataLists(BaseDataLists $lists = null): Response
    {
        //列表类和控制器一一对应，"app/应用/controller/控制器的方法" =》"app\应用\lists\"目录下
        //（例如："app/adminapi/controller/auth/AdminController.php的lists()方法" =》 "app/adminapi/lists/auth/AminLists.php")
        //当对象为空时，自动创建列表对象
        if (is_null($lists)) {
//            $listName = str_replace('.', '\\', App::getNamespace() . '\\lists\\' . $this->request->controller() . ucwords($this->request->action()));
//            $lists = invoke($listName);
        }
        return JsonService::dataLists($lists);
    }


    /**
     * @notes 操作失败
     * @param string $msg
     * @param array $data
     * @param int $code
     * @param int $show
     * @author 乔峰
     * @date 2021/12/27 14:21
     */
    protected function fail(string $msg = 'fail', array $data = [], int $code = 0, int $show = 1): Response
    {
        return JsonService::fail($msg, $data, $code, $show);
    }



    /**
     * @notes 是否免登录验证
     * @return bool
     * @author 乔峰
     * @date 2021/12/27 14:21
     */
    public function isNotNeedLogin($action) : bool
    {
        $notNeedLogin = $this->notNeedLogin;
        if (empty($notNeedLogin)) {
            return false;
        }
        if (!in_array(trim($action), $notNeedLogin)) {
            return false;
        }
        return true;
    }
}