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


use app\common\model\BaseModel;
use app\common\service\FileService;
use think\model\relation\HasOne;
/**
 * DevPayWay模型
 * Class DevPayWay
 * @package app\common\model\pay
 * @property int $id 主键
 * @property int $pay_config_id 支付配置ID
 * @property int $scene 场景:1-微信小程序;2-微信公众号;3-H5;4-PC;5-APP;
 * @property int $is_default 是否默认支付:0-否;1-是;
 * @property int $status 状态:0-关闭;1-开启;

 */
class PayWay extends BaseModel
{
    protected $name = 'dev_pay_way';
    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //支付配置ID
        'pay_config_id' => 'int',
        //场景:1-微信小程序;2-微信公众号;3-H5;4-PC;5-APP;
        'scene' => 'int',
        //是否默认支付:0-否;1-是;
        'is_default' => 'int',
        //状态:0-关闭;1-开启;
        'status' => 'int',
    ];

    public function getIconAttr($value,$data)
    {
        return FileService::getFileUrl($value);
    }

    /**
     * @notes 支付方式名称获取器
     * @param $value
     * @param $data
     * @return mixed
     * @author ljj
     * @date 2021/7/28 4:02 下午
     */
    public static function getPayWayNameAttr($value,$data)
    {
        return PayConfig::where('id',$data['pay_config_id'])->value('name');
    }

    /**
     * @notes 关联支配配置模型
     * @return HasOne
     * @author ljj
     * @date 2021/10/11 3:04 下午
     */
    public function payConfig()
    {
        return $this->hasOne(PayConfig::class,'id','pay_config_id');
    }
}