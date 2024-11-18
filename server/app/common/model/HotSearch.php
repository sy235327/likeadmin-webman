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

namespace app\common\model;

/**
 * 热门搜索表模型
 * Class HotSearch
 * @package app\common\model
 * @property int $id 主键 主键
 * @property string $name 关键词
 * @property int $sort 排序号
 * @property int $create_time 创建时间

 */
class HotSearch extends BaseModel
{

    protected $name = 'hot_search';

    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //关键词
        'name' => 'string',
        //排序号
        'sort' => 'int',
        //创建时间
        'create_time' => 'int',
    ];
}