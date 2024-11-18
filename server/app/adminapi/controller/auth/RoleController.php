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

use app\adminapi\{
    logic\auth\RoleLogic,
    lists\auth\RoleLists,
    validate\auth\RoleValidate,
    controller\BaseAdminController
};
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 角色控制器
 * Class RoleController
 * @package app\adminapi\controller\auth
 */
class RoleController extends BaseAdminController
{
    private RoleValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new RoleValidate();
    }
    /**
     * @notes 查看角色列表
     * @author 乔峰
     * @date 2021/12/29 11:49
     */
    public function lists(): Response
    {
        return $this->dataLists(new RoleLists());
    }


    /**
     * @notes 添加权限
     * @author 乔峰
     * @date 2021/12/29 11:49
     */
    public function add(): Response
    {
        $params = $this->validateObj->post()->goCheck('add');
        $res = RoleLogic::add($params);
        if (true === $res) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(RoleLogic::getError());
    }


    /**
     * @notes 编辑角色
     * @author 乔峰
     * @date 2021/12/29 14:18
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $res = RoleLogic::edit($params);
        if (true === $res) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(RoleLogic::getError());
    }


    /**
     * @notes 删除角色
     * @author 乔峰
     * @date 2021/12/29 14:18
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('del');
        RoleLogic::delete($params['id']);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 查看角色详情
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2021/12/29 14:18
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $detail = RoleLogic::detail($params['id']);
        return $this->data($detail);
    }


    /**
     * @notes 获取角色数据
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/10/13 10:39
     */
    public function all(): Response
    {
        $result = RoleLogic::getAllData();
        return $this->data($result);
    }

}