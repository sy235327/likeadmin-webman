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
use app\adminapi\lists\auth\MenuLists;
use app\adminapi\logic\auth\MenuLogic;
use app\adminapi\validate\auth\MenuValidate;


/**
 * 系统菜单权限
 * Class MenuController
 * @package app\adminapi\controller\setting\system
 */
class MenuController extends BaseAdminController
{
    private MenuValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new MenuValidate();
    }
    /**
     * @notes 获取菜单路由
     * @author 乔峰
     * @date 2022/6/29 17:41
     */
    public function route()
    {
        $result = MenuLogic::getMenuByAdminId($this->adminId);
        return $this->data($result);
    }


    /**
     * @notes 获取菜单列表
     * @author 乔峰
     * @date 2022/6/29 17:23
     */
    public function lists()
    {
        return $this->dataLists(new MenuLists());
    }


    /**
     * @notes 菜单详情
     * @author 乔峰
     * @date 2022/6/30 10:07
     */
    public function detail()
    {
        $params = $this->validateObj->goCheck('detail');
        return $this->data(MenuLogic::detail($params));
    }


    /**
     * @notes 添加菜单
     * @author 乔峰
     * @date 2022/6/30 10:07
     */
    public function add()
    {
        $params = $this->validateObj->post()->goCheck('add');
        MenuLogic::add($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 编辑菜单
     * @author 乔峰
     * @date 2022/6/30 10:07
     */
    public function edit()
    {
        $params = $this->validateObj->post()->goCheck('edit');
        MenuLogic::edit($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 删除菜单
     * @author 乔峰
     * @date 2022/6/30 10:07
     */
    public function delete()
    {
        $params = $this->validateObj->post()->goCheck('delete');
        MenuLogic::delete($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 更新状态
     * @author 乔峰
     * @date 2022/7/6 17:04
     */
    public function updateStatus()
    {
        $params = $this->validateObj->post()->goCheck('status');
        MenuLogic::updateStatus($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 获取菜单数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 乔峰
     * @date 2022/10/13 11:03
     */
    public function all()
    {
        $result = MenuLogic::getAllData();
        return $this->data($result);
    }


}