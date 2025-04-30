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


namespace app\common\enum;

/**
 * 协程上下文key
 * Class YesNoEnum
 * @package app\common\enum
 */
class ContextEnum
{
    const BATCHVALIDATE_KEY = "batchValidate";
    const VALIDATEOBJ_KEY = "validateObj";
    const MIDDLEWARE_KEY = "middleware";
    const REQUEST_KEY = "request";
    const ADMIN_ID_KEY = "adminId";
    const ADMIN_INFO_KEY = "adminInfo";
    const USER_ID_KEY = "userId";
    const USER_INFO_KEY = "userInfo";
}