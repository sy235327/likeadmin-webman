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
use app\adminapi\lists\article\ArticleLists;
use app\adminapi\logic\article\ArticleLogic;
use app\adminapi\validate\article\ArticleValidate;

/**
 * 资讯管理控制器
 * Class ArticleController
 * @package app\adminapi\controller\article
 */
class ArticleController extends BaseAdminController
{
    private ArticleValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new ArticleValidate();
    }
    /**
     * @notes  查看资讯列表
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 9:47
     */
    public function lists()
    {
        return $this->dataLists(new ArticleLists());
    }

    /**
     * @notes  添加资讯
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 9:57
     */
    public function add()
    {
        $params = $this->validateObj->post()->goCheck('add');
        ArticleLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }

    /**
     * @notes  编辑资讯
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 10:12
     */
    public function edit()
    {
        $params = $this->validateObj->post()->goCheck('edit');
        $result = ArticleLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(ArticleLogic::getError());
    }

    /**
     * @notes  删除资讯
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 10:17
     */
    public function delete()
    {
        $params = $this->validateObj->post()->goCheck('delete');
        ArticleLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }

    /**
     * @notes  资讯详情
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 10:15
     */
    public function detail()
    {
        $params = $this->validateObj->goCheck('detail');
        $result = ArticleLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes  更改资讯状态
     * @return \support\Response
     * @author heshihu
     * @date 2022/2/22 10:18
     */
    public function updateStatus()
    {
        $params = $this->validateObj->post()->goCheck('status');
        $result = ArticleLogic::updateStatus($params);
        if (true === $result) {
            return $this->success('修改成功', [], 1, 1);
        }
        return $this->fail(ArticleLogic::getError());
    }


}