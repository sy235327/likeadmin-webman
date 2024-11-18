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

namespace app\api\lists;

use app\common\lists\BaseDataLists;

abstract class BaseApiDataLists extends BaseDataLists
{
    protected array $userInfo = [];
    protected int $userId = 0;

    public int $export;

    public function __construct()
    {
        parent::__construct();
        $controllerObject = make($this->request->controller);
        [$this->userId,$this->userInfo] = $controllerObject->getUser();
        $this->export = $this->request->get('export', '');
    }


}