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


use app\api\logic\IndexLogic;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use Workerman\Timer;


/**
 * index
 * Class IndexController
 * @package app\api\controller
 */
class IndexController extends BaseApiController
{


    public array $notNeedLogin = ['index', 'config', 'policy', 'decorate'];


    /**
     * @notes 首页数据
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 段誉
     * @date 2022/9/21 19:15
     */
    public function index(): Response
    {
        $result = IndexLogic::getIndexData();
        return $this->data($result);
    }


    /**
     * @notes 全局配置
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 段誉
     * @date 2022/9/21 19:41
     */
    public function config(): Response
    {
        $result = IndexLogic::getConfigData();
        return $this->data($result);
    }


    /**
     * @notes 政策协议
     * @return Response
     * @author 段誉
     * @date 2022/9/20 20:00
     */
    public function policy(): Response
    {
        $type = $this->request->get('type', '');
        $result = IndexLogic::getPolicyByType($type);
        return $this->data($result);
    }


    /**
     * @notes 装修信息
     * @return Response
     * @author 段誉
     * @date 2022/9/21 18:37
     */
    public function decorate(): Response
    {
        $id = $this->request->get('id');
        $result = IndexLogic::getDecorate($id);
        return $this->data($result);
    }


}