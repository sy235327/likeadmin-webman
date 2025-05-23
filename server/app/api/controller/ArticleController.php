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


use app\api\lists\article\ArticleCollectLists;
use app\api\lists\article\ArticleLists;
use app\api\logic\ArticleLogic;
use support\Response;

/**
 * 文章管理
 * Class ArticleController
 * @package app\api\controller
 */
class ArticleController extends BaseApiController
{

    public array $notNeedLogin = ['lists', 'cate', 'detail'];


    /**
     * @notes 文章列表
     * @return Response
     * @author 段誉
     * @date 2022/9/20 15:30
     */
    public function lists(): Response
    {
        return $this->dataLists(new ArticleLists());
    }


    /**
     * @notes 文章分类列表
     * @return Response
     * @author 段誉
     * @date 2022/9/20 15:30
     */
    public function cate(): Response
    {
        return $this->data(ArticleLogic::cate());
    }


    /**
     * @notes 收藏列表
     * @return Response
     * @author 段誉
     * @date 2022/9/20 16:31
     */
    public function collect(): Response
    {
        return $this->dataLists(new ArticleCollectLists());
    }


    /**
     * @notes 文章详情
     * @return Response
     * @author 段誉
     * @date 2022/9/20 17:09
     */
    public function detail(): Response
    {
        $id = $this->request->get('id');
        $result = ArticleLogic::detail($id, $this->getUserId());
        return $this->data($result);
    }


    /**
     * @notes 加入收藏
     * @return Response
     * @author 段誉
     * @date 2022/9/20 17:01
     */
    public function addCollect(): Response
    {
        $articleId = $this->request->post('id');
        ArticleLogic::addCollect($articleId, $this->getUserId());
        return $this->success('操作成功');
    }


    /**
     * @notes 取消收藏
     * @return Response
     * @author 段誉
     * @date 2022/9/20 17:01
     */
    public function cancelCollect(): Response
    {
        $articleId = $this->request->post('id');
        ArticleLogic::cancelCollect($articleId, $this->getUserId());
        return $this->success('操作成功');
    }


}