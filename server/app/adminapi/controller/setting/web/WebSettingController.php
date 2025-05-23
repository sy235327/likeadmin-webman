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

namespace app\adminapi\controller\setting\web;

use app\adminapi\controller\BaseAdminController;
use app\adminapi\logic\setting\web\WebSettingLogic;
use app\adminapi\validate\setting\WebSettingValidate;
use support\Response;

/**
 * 网站设置
 * Class WebSettingController
 * @package app\adminapi\controller\setting
 */
class WebSettingController extends BaseAdminController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new WebSettingValidate();
    }

    /**
     * @notes 获取网站信息
     * @author 乔峰
     * @date 2021/12/28 15:44
     */
    public function getWebsite(): Response
    {
        $result = WebSettingLogic::getWebsiteInfo();
        return $this->data($result);
    }


    /**
     * @notes 设置网站信息
     * @author 乔峰
     * @date 2021/12/28 15:45
     */
    public function setWebsite(): Response
    {
        $params = $this->validateObj->post()->goCheck('website');
        WebSettingLogic::setWebsiteInfo($params);
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 获取备案信息
     * @author 乔峰
     * @date 2021/12/28 16:10
     */
    public function getCopyright(): Response
    {
        $result = WebSettingLogic::getCopyright();
        return $this->data($result);
    }


    /**
     * @notes 设置备案信息
     * @author 乔峰
     * @date 2021/12/28 16:10
     */
    public function setCopyright(): Response
    {
        $params = $this->request->post();
        $result = WebSettingLogic::setCopyright($params);
        if (false === $result) {
            return $this->fail(WebSettingLogic::getError() ?: '操作失败');
        }
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 设置政策协议
     * @author ljj
     * @date 2022/2/15 11:00 上午
     */
    public function setAgreement(): Response
    {
        $params = $this->request->post();
        WebSettingLogic::setAgreement($params);
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 获取政策协议
     * @author ljj
     * @date 2022/2/15 11:16 上午
     */
    public function getAgreement(): Response
    {
        $result = WebSettingLogic::getAgreement();
        return $this->data($result);
    }

    /**
     * @notes 获取站点统计配置
     * @return Response
     * @author yfdong
     * @date 2024/09/20 22:24
     */
    public function getSiteStatistics(): Response
    {
        $result = WebSettingLogic::getSiteStatistics();
        return $this->data($result);
    }

    /**
     * @notes 获取站点统计配置
     * @return Response
     * @author yfdong
     * @date 2024/09/20 22:51
     */
    public function setSiteStatistics(): Response
    {
        $params = (new WebSettingValidate())->post()->goCheck('siteStatistics');
        WebSettingLogic::setSiteStatistics($params);
        return $this->success('设置成功', [], 1, 1);
    }
}