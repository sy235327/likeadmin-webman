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
use app\adminapi\lists\dept\JobsLists;
use app\adminapi\logic\dept\JobsLogic;
use app\adminapi\validate\dept\JobsValidate;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;


/**
 * 岗位管理控制器
 * Class JobsController
 * @package app\adminapi\controller\dept
 */
class JobsController extends BaseAdminController
{
    private JobsValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new JobsValidate();
    }
    /**
     * @notes 岗位列表
     * @author 乔峰
     * @date 2022/5/26 10:00
     */
    public function lists(): Response
    {
        return $this->dataLists(new JobsLists());
    }


    /**
     * @notes 添加岗位
     * @author 乔峰
     * @date 2022/5/25 18:40
     */
    public function add(): Response
    {
        $params = $this->validateObj->post()->goCheck('add');
        JobsLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑岗位
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $result = JobsLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(JobsLogic::getError());
    }


    /**
     * @notes 删除岗位
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('delete');
        JobsLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取岗位详情
     * @author 乔峰
     * @date 2022/5/25 18:41
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $result = JobsLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取岗位数据
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/10/13 10:31
     */
    public function all(): Response
    {
        $result = JobsLogic::getAllData();
        return $this->data($result);
    }


}