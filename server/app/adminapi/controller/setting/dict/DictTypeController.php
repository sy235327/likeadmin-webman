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

namespace app\adminapi\controller\setting\dict;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\setting\dict\DictTypeLists;
use app\adminapi\logic\setting\dict\DictTypeLogic;
use app\adminapi\validate\dict\DictTypeValidate;


/**
 * 字典类型
 * Class DictTypeController
 * @package app\adminapi\controller\dict
 */
class DictTypeController extends BaseAdminController
{
    private DictTypeValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new DictTypeValidate();
    }

    /**
     * @notes 获取字典类型列表
     * @author 乔峰
     * @date 2022/6/20 15:50
     */
    public function lists()
    {
        return $this->dataLists(new DictTypeLists());
    }


    /**
     * @notes 添加字典类型
     * @author 乔峰
     * @date 2022/6/20 16:24
     */
    public function add()
    {
        $params = $this->validateObj->post()->goCheck('add');
        DictTypeLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑字典类型
     * @author 乔峰
     * @date 2022/6/20 16:25
     */
    public function edit()
    {
        $params = $this->validateObj->post()->goCheck('edit');
        DictTypeLogic::edit($params);
        return $this->success('编辑成功', [], 1, 1);
    }


    /**
     * @notes 删除字典类型
     * @author 乔峰
     * @date 2022/6/20 16:25
     */
    public function delete()
    {
        $params = $this->validateObj->post()->goCheck('delete');
        DictTypeLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取字典详情
     * @author 乔峰
     * @date 2022/6/20 16:25
     */
    public function detail()
    {
        $params = $this->validateObj->goCheck('detail');
        $result = DictTypeLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取字典类型数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 乔峰
     * @date 2022/10/13 10:46
     */
    public function all()
    {
        $result = DictTypeLogic::getAllData();
        return $this->data($result);
    }


}