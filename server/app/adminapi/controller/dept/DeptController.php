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

namespace app\adminapi\controller\dept;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\logic\dept\DeptLogic;
use app\adminapi\validate\dept\DeptValidate;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 部门管理控制器
 * Class DeptController
 * @package app\adminapi\controller\dept
 */
class DeptController extends BaseAdminController
{
    private DeptValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new DeptValidate();
    }
    /**
     * @notes 部门列表
     * @author 乔峰
     * @date 2022/5/25 18:07
     */
    public function lists(): Response
    {
        $params = $this->request->get();
        $result = DeptLogic::lists($params);
        return $this->success('',$result);
    }


    /**
     * @notes 上级部门
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/5/26 18:36
     */
    public function leaderDept(): Response
    {
        $result = DeptLogic::leaderDept();
        return $this->success('',$result);
    }


    /**
     * @notes 添加部门
     * @author 乔峰
     * @date 2022/5/25 18:40
     */
    public function add(): Response
    {
        $params = $this->validateObj->post()->goCheck('add');
        DeptLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑部门
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $result = DeptLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(DeptLogic::getError());
    }


    /**
     * @notes 删除部门
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('delete');
        DeptLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取部门详情
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $result = DeptLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取部门数据
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/10/13 10:28
     */
    public function all(): Response
    {
        $result = DeptLogic::getAllData();
        return $this->data($result);
    }


}