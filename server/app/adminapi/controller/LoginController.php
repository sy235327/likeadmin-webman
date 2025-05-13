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

namespace app\adminapi\controller;

use app\adminapi\logic\LoginLogic;
use app\adminapi\validate\LoginValidate;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use support\think\Cache;

/**
 * 管理员登录控制器
 * Class LoginController
 * @package app\adminapi\controller
 */
class LoginController extends BaseAdminController
{
    public array $notNeedLogin = ['account'];

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new LoginValidate();
    }
    /**
     * @notes 账号登录
     * @date 2021/6/30 17:01
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     */
    public function account(): Response
    {
        $params = $this->validateObj->post()->goCheck();
        return $this->data((new LoginLogic())->login($params));
    }

    /**
     * @notes 退出登录
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2021/7/8 00:36
     */
    public function logout(): Response
    {
        //退出登录情况特殊，只有成功的情况，也不需要token验证
        (new LoginLogic())->logout($this->getAdminInfo());
        return $this->success();
    }
}