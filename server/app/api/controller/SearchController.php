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

namespace app\api\controller;


use app\api\logic\SearchLogic;
use support\Response;

/**
 * 搜索
 * Class HotSearchController
 * @package app\api\controller
 */
class SearchController extends BaseApiController
{

    public array $notNeedLogin = ['hotLists'];

    /**
     * @notes 热门搜素
     * @return Response
     * @author 段誉
     * @date 2022/9/22 10:14
     */
    public function hotLists(): Response
    {
        return $this->data(SearchLogic::hotLists());
    }

}