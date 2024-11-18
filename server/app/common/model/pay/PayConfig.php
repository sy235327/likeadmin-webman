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

namespace app\common\model\pay;

use app\common\enum\PayEnum;
use app\common\model\BaseModel;
use app\common\service\FileService;

/**
 * DevPayConfig模型
 * Class DevPayConfig
 * @package app\common\model\pay
 * @property int $id 主键
 * @property string $name 模版名称
 * @property int $pay_way 支付方式:1-余额支付;2-微信支付;3-支付宝支付;
 * @property string $config 对应支付配置(json字符串)
 * @property string $icon 图标
 * @property int $sort 排序
 * @property string $remark 备注

 */
class PayConfig extends BaseModel
{
    protected $name = 'dev_pay_config';
    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //模版名称
        'name' => 'string',
        //支付方式:1-余额支付;2-微信支付;3-支付宝支付;
        'pay_way' => 'int',
        //对应支付配置(json字符串)
        'config' => 'string',
        //图标
        'icon' => 'string',
        //排序
        'sort' => 'int',
        //备注
        'remark' => 'string',
    ];


    // 设置json类型字段
    protected $json = ['config'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    /**
     * @notes 支付图标获取器 - 路径添加域名
     * @param $value
     * @return string
     * @author ljj
     * @date 2021/7/28 2:12 下午
     */
    public function getIconAttr($value)
    {
        return empty($value) ? '' : FileService::getFileUrl($value);
    }

    /**
     * @notes 支付方式名称获取器
     * @param $value
     * @param $data
     * @return string|string[]
     * @author ljj
     * @date 2021/7/31 2:24 下午
     */
    public function getPayWayNameAttr($value,$data)
    {
        return PayEnum::getPayDesc($data['pay_way']);
    }
}