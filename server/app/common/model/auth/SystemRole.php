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
use think\model\concern\SoftDelete;
use think\model\relation\HasMany;

/**
 * 角色模型
 * Class Role
 * @package app\common\model
 * @property int $id 主键
 * @property string $name 名称
 * @property string $desc 描述
 * @property int $sort 排序
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class SystemRole extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    protected $name = 'system_role';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //名称
        'name' => 'string',
        //描述
        'desc' => 'string',
        //排序
        'sort' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
    /**
     * @notes 角色与菜单关联关系
     * @return HasMany
     * @author 乔峰
     * @date 2022/7/6 11:16
     */
    public function roleMenuIndex()
    {
        return $this->hasMany(SystemRoleMenu::class, 'role_id');
    }
}