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


namespace app\common\model\user;

use app\common\model\BaseModel;

/**
 * 用户登录token信息
 * Class UserSession
 * @package app\common\model\user
 * @property int $id 主键
 * @property int $user_id 用户id
 * @property int $terminal 客户端类型：1-微信小程序；2-微信公众号；3-手机H5；4-电脑PC；5-苹果APP；6-安卓APP
 * @property string $token 令牌
 * @property int $update_time 更新时间
 * @property int $expire_time 到期时间
 */
class UserSession extends BaseModel
{
    protected $name = 'user_session';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //用户id
        'user_id' => 'int',
        //客户端类型：1-微信小程序；2-微信公众号；3-手机H5；4-电脑PC；5-苹果APP；6-安卓APP
        'terminal' => 'int',
        //令牌
        'token' => 'string',
        //更新时间
        'update_time' => 'int',
        //到期时间
        'expire_time' => 'int',
    ];

}