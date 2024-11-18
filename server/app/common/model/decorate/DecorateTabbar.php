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
use app\common\service\FileService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;


/**
 * 装修配置-底部导航
 * Class DecorateTabbar
 * @package app\common\model\decorate
 * @property int $id 主键 主键
 * @property string $name 导航名称
 * @property string $selected 未选图标
 * @property string $unselected 已选图标
 * @property string $link 链接地址
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class DecorateTabbar extends BaseModel
{
    protected $name = 'decorate_tabbar';

    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //导航名称
        'name' => 'string',
        //未选图标
        'selected' => 'string',
        //已选图标
        'unselected' => 'string',
        //链接地址
        'link' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];
    // 设置json类型字段
    protected $json = ['link'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;


    /**
     * @notes 获取底部导航列表
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 段誉
     * @date 2022/9/23 12:07
     */
    public static function getTabbarLists()
    {
        $tabbar = self::select()->toArray();

        if (empty($tabbar)) {
           return $tabbar;
        }

        foreach ($tabbar as &$item) {
            if (!empty($item['selected'])) {
                $item['selected'] = FileService::getFileUrl($item['selected']);
            }
            if (!empty($item['unselected'])) {
                $item['unselected'] = FileService::getFileUrl($item['unselected']);
            }
        }

        return $tabbar;
    }
}