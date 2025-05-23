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

namespace app\adminapi\controller\article;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\article\ArticleCateLists;
use app\adminapi\logic\article\ArticleCateLogic;
use app\adminapi\validate\article\ArticleCateValidate;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 资讯分类管理控制器
 * Class ArticleCateController
 * @package app\adminapi\controller\article
 */
class ArticleCateController extends BaseAdminController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new ArticleCateValidate();
    }
    /**
     * @notes  查看资讯分类列表
     * @return Response
     * @author heshihu
     * @date 2022/2/21 17:11
     */
    public function lists(): Response
    {
        return $this->dataLists(new ArticleCateLists());
    }


    /**
     * @notes  添加资讯分类
     * @return Response
     * @author heshihu
     * @date 2022/2/21 17:31
     */
    public function add(): Response
    {
        $params = $this->validateObj->post()->goCheck('add');
        ArticleCateLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes  编辑资讯分类
     * @return Response
     * @author heshihu
     * @date 2022/2/21 17:49
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $result = ArticleCateLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(ArticleCateLogic::getError());
    }


    /**
     * @notes  删除资讯分类
     * @return Response
     * @author heshihu
     * @date 2022/2/21 17:52
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('delete');
        ArticleCateLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes  资讯分类详情
     * @return Response
     * @author heshihu
     * @date 2022/2/21 17:54
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $result = ArticleCateLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes  更改资讯分类状态
     * @return Response
     * @author heshihu
     * @date 2022/2/21 10:15
     */
    public function updateStatus(): Response
    {
        $params = $this->validateObj->post()->goCheck('status');
        $result = ArticleCateLogic::updateStatus($params);
        if (true === $result) {
            return $this->success('修改成功', [], 1, 1);
        }
        return $this->fail(ArticleCateLogic::getError());
    }


    /**
     * @notes 获取文章分类
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 段誉
     * @date 2022/10/13 10:54
     */
    public function all(): Response
    {
        $result = ArticleCateLogic::getAllData();
        return $this->data($result);
    }


}