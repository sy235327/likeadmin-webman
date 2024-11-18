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

namespace app\adminapi\lists\auth;

use app\adminapi\lists\BaseAdminDataLists;
use app\common\model\auth\SystemMenu;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;


/**
 *  菜单列表
 * Class MenuLists
 * @package app\adminapi\lists\auth
 */
class MenuLists extends BaseAdminDataLists
{

    /**
     * @notes 获取菜单列表
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/6/29 16:41
     */
    public function lists(): array
    {
        $lists = SystemMenu::order(['sort' => 'desc', 'id' => 'asc'])
            ->select()
            ->toArray();
        return linear_to_tree($lists, 'children');
    }


    /**
     * @notes 获取菜单数量
     * @return int
     * @author 乔峰
     * @date 2022/6/29 16:41
     */
    public function count(): int
    {
        return SystemMenu::count();
    }

}