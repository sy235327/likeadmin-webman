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

namespace app\adminapi\controller\notice;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\notice\NoticeSettingLists;
use app\adminapi\logic\notice\NoticeLogic;
use app\adminapi\validate\notice\NoticeValidate;

/**
 * 通知控制器
 * Class NoticeController
 * @package app\adminapi\controller\notice
 */
class NoticeController extends BaseAdminController
{
    private NoticeValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new NoticeValidate();
    }
    /**
     * @notes 查看通知设置列表
     * @author 乔峰
     * @date 2022/3/29 11:18
     */
    public function settingLists()
    {
        return $this->dataLists(new NoticeSettingLists());
    }


    /**
     * @notes 查看通知设置详情
     * @author 乔峰
     * @date 2022/3/29 11:18
     */
    public function detail()
    {
        $params = $this->validateObj->goCheck('detail');
        $result = NoticeLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 通知设置
     * @author 乔峰
     * @date 2022/3/29 11:18
     */
    public function set()
    {
        $params = $this->request->post();
        $result = NoticeLogic::set($params);
        if ($result) {
            return $this->success('设置成功');
        }
        return $this->fail(NoticeLogic::getError());
    }
}