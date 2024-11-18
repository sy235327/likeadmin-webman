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
 * 角色与菜单权限关系
 * Class SystemRoleMenu
 * @package app\common\model\auth
 * @property int $role_id 角色ID
 * @property int $menu_id 主键 菜单ID
 */
class SystemRoleMenu extends BaseModel
{
    protected $name = 'system_role_menu';
    //设置字段信息
    protected $schema = [
        //角色ID
        'role_id' => 'int',
        //主键 菜单ID
        'menu_id' => 'int',
    ];
}