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
namespace app\common\service\wechat;


use EasyWeChat\Kernel\Exceptions\Exception;
use EasyWeChat\Kernel\Exceptions\HttpException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\HttpClient\Response;
use EasyWeChat\MiniApp\Application;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;


/**
 * 微信功能类
 * Class WeChatMnpService
 * @package app\common\service
 */
class WeChatMnpService
{

    protected $app;

    protected $config;

    public function __construct()
    {
        $this->config = $this->getConfig();
        $this->app = new Application($this->config);
    }


    /**
     * @notes 配置
     * @return array
     * @throws \Exception
     * @author 段誉
     * @date 2023/2/27 12:03
     */
    protected function getConfig()
    {
        $config = WeChatConfigService::getMnpConfig();
        if (empty($config['app_id']) || empty($config['secret'])) {
            throw new \Exception('请先设置小程序配置');
        }
        return $config;
    }


    /**
     * @notes 小程序-根据code获取微信信息
     * @param string $code
     * @return array
     * @throws Exception
     * @throws HttpException
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @author 段誉
     * @date 2023/2/27 11:03
     */
    public function getMnpResByCode(string $code)
    {
        $utils = $this->app->getUtils();
        $response = $utils->codeToSession($code);

        if (!isset($response['openid']) || empty($response['openid'])) {
            throw new Exception('获取openID失败');
        }

        return $response;
    }


    /**
     * @notes 获取手机号
     * @param string $code
     * @return Response|ResponseInterface
     * @throws TransportExceptionInterface
     * @author 段誉
     * @date 2023/2/27 11:46
     */
    public function getUserPhoneNumber(string $code)
    {
        return $this->app->getClient()->postJson('wxa/business/getuserphonenumber', [
            'code' => $code,
        ]);
    }


}