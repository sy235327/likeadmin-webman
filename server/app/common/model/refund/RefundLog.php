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
use app\common\model\auth\Admin;
use app\common\model\BaseModel;


/**
 * 退款日志模型
 * Class RefundLog
 * @package app\common\model\refund
 * @property int $id 主键 id
 * @property string $sn 编号
 * @property int $record_id 退款记录id
 * @property int $user_id 关联用户
 * @property int $handle_id 处理人id（管理员id）
 * @property float $order_amount 订单总的应付款金额，冗余字段
 * @property float $refund_amount 本次退款金额
 * @property int $refund_status 退款状态，0退款中，1退款成功，2退款失败
 * @property string $refund_msg 退款信息
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class RefundLog extends BaseModel
{
    protected $name = 'refund_log';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //编号
        'sn' => 'string',
        //退款记录id
        'record_id' => 'int',
        //关联用户
        'user_id' => 'int',
        //处理人id（管理员id）
        'handle_id' => 'int',
        //订单总的应付款金额，冗余字段
        'order_amount' => 'float',
        //本次退款金额
        'refund_amount' => 'float',
        //退款状态，0退款中，1退款成功，2退款失败
        'refund_status' => 'int',
        //退款信息
        'refund_msg' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];


    /**
     * @notes 操作人描述
     * @param $value
     * @param $data
     * @return mixed
     * @author 段誉
     * @date 2022/12/1 10:55
     */
    public function getHandlerAttr($value, $data)
    {
        return Admin::where('id', $data['handle_id'])->value('name');
    }


    /**
     * @notes 退款状态描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 段誉
     * @date 2022/12/1 10:55
     */
    public function getRefundStatusTextAttr($value, $data)
    {
        return RefundEnum::getStatusDesc($data['refund_status']);
    }

}
