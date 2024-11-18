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

namespace app\adminapi\controller\auth;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\auth\AdminLists;
use app\adminapi\validate\auth\AdminValidate;
use app\adminapi\logic\auth\AdminLogic;
use app\adminapi\validate\auth\editSelfValidate;
use app\common\model\auth\Admin;
use support\Response;

/**
 * 管理员控制器
 * Class AdminController
 * @package app\adminapi\controller\auth
 */
class AdminController extends BaseAdminController
{
    private AdminValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new AdminValidate();
    }
    public array $notNeedLogin = [];
    /**
     * @notes 查看管理员列表
     * @author 乔峰
     * @date 2021/12/29 9:55
     */
    public function lists(): Response
    {
        return $this->dataLists(new AdminLists());
    }


    /**
     * @notes 添加管理员
     * @author 乔峰
     * @date 2021/12/29 10:21
     */
    public function add(): Response
    {
        $params = $this->validateObj->post()->goCheck('add');
        $result = AdminLogic::add($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(AdminLogic::getError());
    }


    /**
     * @notes 编辑管理员
     * @author 乔峰
     * @date 2021/12/29 11:03
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $result = AdminLogic::edit($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(AdminLogic::getError());
    }


    /**
     * @notes 删除管理员
     * @author 乔峰
     * @date 2021/12/29 11:03
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('delete');
        $result = AdminLogic::delete($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(AdminLogic::getError());
    }


    /**
     * @notes 查看管理员详情
     * @author 乔峰
     * @date 2021/12/29 11:07
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $result = AdminLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取当前管理员信息
     * @author 乔峰
     * @date 2021/12/31 10:53
     */
    public function mySelf(): Response
    {
        $result = AdminLogic::detail(['id' => $this->adminId], 'auth');
        return $this->data($result);
    }


    /**
     * @notes 编辑超级管理员信息
     * @author 乔峰
     * @date 2022/4/8 17:54
     */
    public function editSelf(): Response
    {
        $params = (new editSelfValidate())->post()->goCheck('', ['admin_id' => $this->adminId]);
        $result = AdminLogic::editSelf($params);
        return $this->success('操作成功', [], 1, 1);
    }
}