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
 * 系统菜单
 * Class SystemMenu
 * @package app\common\model\auth
 * @property int $id 主键 主键
 * @property int $pid 上级菜单
 * @property string $type 权限类型: M=目录，C=菜单，A=按钮
 * @property string $name 菜单名称
 * @property string $icon 菜单图标
 * @property int $sort 菜单排序
 * @property string $perms 权限标识
 * @property string $paths 路由地址
 * @property string $component 前端组件
 * @property string $selected 选中路径
 * @property string $params 路由参数
 * @property int $is_cache 是否缓存: 0=否, 1=是
 * @property int $is_show 是否显示: 0=否, 1=是
 * @property int $is_disable 是否禁用: 0=否, 1=是
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class SystemMenu extends BaseModel
{
    protected $name = 'system_menu';
    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //上级菜单
        'pid' => 'int',
        //权限类型: M=目录，C=菜单，A=按钮
        'type' => 'string',
        //菜单名称
        'name' => 'string',
        //菜单图标
        'icon' => 'string',
        //菜单排序
        'sort' => 'int',
        //权限标识
        'perms' => 'string',
        //路由地址
        'paths' => 'string',
        //前端组件
        'component' => 'string',
        //选中路径
        'selected' => 'string',
        //路由参数
        'params' => 'string',
        //是否缓存: 0=否, 1=是
        'is_cache' => 'int',
        //是否显示: 0=否, 1=是
        'is_show' => 'int',
        //是否禁用: 0=否, 1=是
        'is_disable' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];


}