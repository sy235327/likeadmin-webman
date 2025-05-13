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


use app\api\validate\PayValidate;
use app\common\enum\user\UserTerminalEnum;
use app\common\logic\PaymentLogic;
use app\common\service\pay\AliPayService;
use app\common\service\pay\WeChatPayService;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\RuntimeException;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use support\Response;
use Throwable;

/**
 * 支付
 * Class PayController
 * @package app\api\controller
 */
class PayController extends BaseApiController
{

    public array $notNeedLogin = ['notifyMnp', 'notifyOa', 'aliNotify'];

    /**
     * @notes 支付方式
     * @return Response
     * @author 段誉
     * @date 2023/2/24 17:54
     */
    public function payWay(): Response
    {
        $params = (new PayValidate())->goCheck('payway');
        $result = PaymentLogic::getPayWay($this->getUserId(), $this->getUserInfo()['terminal'], $params);
        if ($result === false) {
            return $this->fail(PaymentLogic::getError());
        }
        return $this->data($result);
    }


    /**
     * @notes 预支付
     * @return Response
     * @author 段誉
     * @date 2023/2/28 14:21
     */
    public function prepay(): Response
    {
        $params = (new PayValidate())->post()->goCheck();
        //订单信息
        $order = PaymentLogic::getPayOrderInfo($params);
        if (false === $order) {
            return $this->fail(PaymentLogic::getError(), $params);
        }
        //支付流程
        $redirectUrl = $params['redirect'] ?? '/pages/payment/payment';
        $result = PaymentLogic::pay($params['pay_way'], $params['from'], $order, $this->getUserInfo()['terminal'], $redirectUrl);
        if (false === $result) {
            return $this->fail(PaymentLogic::getError(), $params);
        }
        return $this->success('', $result);
    }


    /**
     * @notes 获取支付状态
     * @return Response
     * @author 段誉
     * @date 2023/3/1 16:23
     */
    public function payStatus(): Response
    {
        $params = (new PayValidate())->goCheck('status', ['user_id' => $this->getUserId()]);
        $result = PaymentLogic::getPayStatus($params);
        if ($result === false) {
            return $this->fail(PaymentLogic::getError());
        }
        return $this->data($result);
    }


    /**
     * @notes 小程序支付回调
     * @return Response
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws Throwable
     * @author 段誉
     * @date 2023/2/28 14:21
     */
    public function notifyMnp(): Response
    {
        return (new WeChatPayService(UserTerminalEnum::WECHAT_MMP))->notify();
    }


    /**
     * @notes 公众号支付回调
     * @return Response
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws Throwable
     * @throws InvalidArgumentException
     * @author 段誉
     * @date 2023/2/28 14:21
     */
    public function notifyOa(): Response
    {
        return (new WeChatPayService(UserTerminalEnum::WECHAT_OA))->notify();
    }
    /**
     * @notes 支付宝回调
     * @author mjf
     * @return Response
     * @date 2024/3/18 16:50
     */
    public function aliNotify(): Response
    {
        $params = $this->request->post();
        $result = (new AliPayService())->notify($params);
        if (true === $result) {
            return response('success');
        } else {
            return response('fail');
        }
    }

}
