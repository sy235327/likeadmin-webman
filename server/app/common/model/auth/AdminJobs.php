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

/**
 * 岗位关联表模型
 * Class AdminJobs
 * @package app\common\model\auth
 * @property int $admin_id 管理员id
 * @property int $jobs_id 主键 岗位id

 */
class AdminJobs extends BaseModel
{
    protected $name = 'admin_jobs';
    //设置字段信息
    protected $schema = [
        //管理员id
        'admin_id' => 'int',
        //主键 岗位id
        'jobs_id' => 'int',
    ];
    /**
     * @notes 删除用户关联岗位
     * @param $adminId
     * @return bool
     * @author 乔峰
     * @date 2022/11/25 14:14
     */
    public static function delByUserId($adminId)
    {
        return self::where(['admin_id' => $adminId])->delete();
    }
}