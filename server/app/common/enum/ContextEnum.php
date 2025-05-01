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
    /**
     * 批量验证KEY
     * @var string
     */
    const BATCHVALIDATE_KEY = "batchValidate";
    /**
     * 验证对象KEY
     * @var string
     */
    const VALIDATEOBJ_KEY = "validateObj";
    /**
     * 动态拦截器KEY
     * @var string
     */
    const MIDDLEWARE_KEY = "middleware";
    /**
     * 请求对象KEY
     * @var string
     */
    const REQUEST_KEY = "request";
    /**
     * 管理员ID KEY
     * @var string
     */
    const ADMIN_ID_KEY = "adminId";
    /**
     * 管理员信息 KEY
     * @var string
     */
    const ADMIN_INFO_KEY = "adminInfo";
    /**
     * 用户ID KEY
     * @var string
     */
    const USER_ID_KEY = "userId";
    /**
     * 用户信息 KEY
     * @var string
     */
    const USER_INFO_KEY = "userInfo";
    /**
     * logic返回码 KEY
     * @var string
     */
    const RETURN_CODE_KEY = 'base_logic_return_code';
    /**
     * logic错误 KEY
     * @var string
     */
    const ERROR_CODE_KEY = 'base_logic_error_code';
    /**
     * logic返回数据 KEY
     * @var string
     */
    const RETURN_DATA_KEY = 'base_logic_return_data';
    /**
     * logic返回消息 KEY
     * @var string
     */
    const TRANS_NUMBER_KEY = 'base_logic_trans_number';
}