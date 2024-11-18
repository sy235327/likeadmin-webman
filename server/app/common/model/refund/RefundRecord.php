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

namespace app\common\model\refund;


use app\common\enum\RefundEnum;
use app\common\model\BaseModel;


/**
 * 退款记录模型
 * Class RefundRecord
 * @package app\common\model\refund
 * @property int $id 主键 id
 * @property string $sn 退款编号
 * @property int $user_id 关联用户
 * @property int $order_id 来源订单id
 * @property string $order_sn 来源单号
 * @property string $order_type 订单来源 order-商品订单 recharge-充值订单
 * @property float $order_amount 订单总的应付款金额，冗余字段
 * @property float $refund_amount 本次退款金额
 * @property string $transaction_id 第三方平台交易流水号
 * @property int $refund_way 退款方式 1-线上退款 2-线下退款
 * @property int $refund_type 退款类型 1-后台退款
 * @property int $refund_status 退款状态，0退款中，1退款成功，2退款失败
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class RefundRecord extends BaseModel
{
    protected $name = 'refund_record';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //退款编号
        'sn' => 'string',
        //关联用户
        'user_id' => 'int',
        //来源订单id
        'order_id' => 'int',
        //来源单号
        'order_sn' => 'string',
        //订单来源 order-商品订单 recharge-充值订单
        'order_type' => 'string',
        //订单总的应付款金额，冗余字段
        'order_amount' => 'float',
        //本次退款金额
        'refund_amount' => 'float',
        //第三方平台交易流水号
        'transaction_id' => 'string',
        //退款方式 1-线上退款 2-线下退款
        'refund_way' => 'int',
        //退款类型 1-后台退款
        'refund_type' => 'int',
        //退款状态，0退款中，1退款成功，2退款失败
        'refund_status' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];

    /**
     * @notes 退款类型描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 段誉
     * @date 2022/12/1 10:41
     */
    public function getRefundTypeTextAttr($value, $data)
    {
        return RefundEnum::getTypeDesc($data['refund_type']);
    }


    /**
     * @notes 退款状态描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 段誉
     * @date 2022/12/1 10:44
     */
    public function getRefundStatusTextAttr($value, $data)
    {
        return RefundEnum::getStatusDesc($data['refund_status']);
    }


    /**
     * @notes 退款方式描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 段誉
     * @date 2022/12/6 11:08
     */
    public function getRefundWayTextAttr($value, $data)
    {
        return RefundEnum::getWayDesc($data['refund_way']);
    }

}
