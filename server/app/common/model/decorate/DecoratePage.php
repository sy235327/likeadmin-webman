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
namespace app\common\model\decorate;


use app\common\model\BaseModel;


/**
 * 装修配置-页面
 * Class DecorateTabbar
 * @package app\common\model\decorate
 * @property int $id 主键 主键
 * @property int $type 页面类型 1=商城首页, 2=个人中心, 3=客服设置 4-PC首页
 * @property string $name 页面名称
 * @property string $data 页面数据
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class DecoratePage extends BaseModel
{

    protected $name = 'decorate_page';

    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //页面类型 1=商城首页, 2=个人中心, 3=客服设置 4-PC首页
        'type' => 'int',
        //页面名称
        'name' => 'string',
        //页面数据
        'data' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];

}