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

namespace app\common\model\auth;

use app\common\model\BaseModel;
use think\model\relation\HasOne;
/**
 * 管理员会话表模型
 * Class AdminSession
 * @package app\common\model\auth
 * @property int $id 主键
 * @property int $admin_id 用户id
 * @property int $terminal 客户端类型：1-pc管理后台 2-mobile手机管理后台
 * @property string $token 令牌
 * @property int $update_time 更新时间
 * @property int $expire_time 到期时间

 */
class AdminSession extends BaseModel
{
    protected $name = 'admin_session';
    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //用户id
        'admin_id' => 'int',
        //客户端类型：1-pc管理后台 2-mobile手机管理后台
        'terminal' => 'int',
        //令牌
        'token' => 'string',
        //更新时间
        'update_time' => 'int',
        //到期时间
        'expire_time' => 'int',
    ];

    /**
     * @notes 关联管理员表
     * @return HasOne
     * @author 令狐冲
     * @date 2021/7/5 14:39
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id')
            ->field('id,multipoint_login');
    }
}