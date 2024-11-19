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

namespace app\common\model\recharge;

use app\common\enum\PayEnum;
use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 充值订单模型
 * Class RechargeOrder
 * @package app\common\model\recharge
 * @property int $id 主键 id
 * @property string $sn 订单编号
 * @property int $user_id 用户id
 * @property string $pay_sn 支付编号-冗余字段，针对微信同一主体不同客户端支付需用不同订单号预留。
 * @property int $pay_way 支付方式 2-微信支付 3-支付宝支付
 * @property int $pay_status 支付状态：0-待支付；1-已支付
 * @property int $pay_time 支付时间
 * @property float $order_amount 充值金额
 * @property int $order_terminal 终端
 * @property string $transaction_id 第三方平台交易流水号
 * @property int $refund_status 退款状态 0-未退款 1-已退款
 * @property int $refund_transaction_id 退款交易流水号
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class RechargeOrder extends BaseModel
{
    use SoftDelete;

    protected $name = 'recharge_order';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //订单编号
        'sn' => 'string',
        //用户id
        'user_id' => 'int',
        //支付编号-冗余字段，针对微信同一主体不同客户端支付需用不同订单号预留。
        'pay_sn' => 'string',
        //支付方式 2-微信支付 3-支付宝支付
        'pay_way' => 'int',
        //支付状态：0-待支付；1-已支付
        'pay_status' => 'int',
        //支付时间
        'pay_time' => 'int',
        //充值金额
        'order_amount' => 'float',
        //终端
        'order_terminal' => 'int',
        //第三方平台交易流水号
        'transaction_id' => 'string',
        //退款状态 0-未退款 1-已退款
        'refund_status' => 'int',
        //退款交易流水号
        'refund_transaction_id' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];


    /**
     * @notes 支付方式
     * @param $value
     * @return string|string[]
     * @author 段誉
     * @date 2023/2/23 18:32
     */
    public function getPayWayTextAttr($value, $data)
    {
        return PayEnum::getPayDesc($data['pay_way']);
    }


    /**
     * @notes 支付状态
     * @param $value
     * @return string|string[]
     * @author 段誉
     * @date 2023/2/23 18:32
     */
    public function getPayStatusTextAttr($value, $data)
    {
        return PayEnum::getPayStatusDesc($data['pay_status']);
    }
}