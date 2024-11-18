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

namespace app\common\model\notice;


use app\common\enum\DefaultEnum;
use app\common\enum\notice\NoticeEnum;
use app\common\model\BaseModel;

/**
 * 通知设置表模型
 * Class NoticeSetting
 * @package app\common\model\notice
 * @property int $id 主键
 * @property int $scene_id 场景id
 * @property string $scene_name 场景名称
 * @property string $scene_desc 场景描述
 * @property int $recipient 接收者 1-用户 2-平台
 * @property int $type 通知类型: 1-业务通知 2-验证码
 * @property string $system_notice 系统通知设置
 * @property string $sms_notice 短信通知设置
 * @property string $oa_notice 公众号通知设置
 * @property string $mnp_notice 小程序通知设置
 * @property string $support 支持的发送类型 1-系统通知 2-短信通知 3-微信模板消息 4-小程序提醒
 * @property int $update_time 更新时间

 */
class NoticeSetting extends BaseModel
{
    protected $name = 'notice_setting';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //场景id
        'scene_id' => 'int',
        //场景名称
        'scene_name' => 'string',
        //场景描述
        'scene_desc' => 'string',
        //接收者 1-用户 2-平台
        'recipient' => 'int',
        //通知类型: 1-业务通知 2-验证码
        'type' => 'int',
        //系统通知设置
        'system_notice' => 'string',
        //短信通知设置
        'sms_notice' => 'string',
        //公众号通知设置
        'oa_notice' => 'string',
        //小程序通知设置
        'mnp_notice' => 'string',
        //支持的发送类型 1-系统通知 2-短信通知 3-微信模板消息 4-小程序提醒
        'support' => 'string',
        //更新时间
        'update_time' => 'int',
    ];


    /**
     * @notes 短信通知状态
     * @param $value
     * @param $data
     * @return string|string[]
     * @author ljj
     * @date 2022/2/16 3:22 下午
     */
    public function getSmsStatusDescAttr($value,$data): array|string
    {
        if ($data['sms_notice']) {
            $sms_text = json_decode($data['sms_notice'],true);
            return DefaultEnum::getEnableDesc($sms_text['status']);
        }else {
            return '停用';
        }
    }

    /**
     * @notes 通知类型
     * @param $value
     * @param $data
     * @return string|string[]
     * @author ljj
     * @date 2022/2/17 2:50 下午
     */
    public function getTypeDescAttr($value,$data): array|string
    {
        return NoticeEnum::getTypeDesc($data['type']);
    }


    /**
     * @notes 接收者描述获取器
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/8/18 16:42
     */
    public function getRecipientDescAttr($value): string
    {
        $desc = [
            1 => '买家',
            2 => '卖家',
        ];
        return $desc[$value] ?? '';
    }

    /**
     * @notes 系统通知获取器
     * @param $value
     * @return array|mixed
     * @author Tab
     * @date 2021/8/18 19:11
     */
    public function getSystemNoticeAttr($value): mixed
    {
        return empty($value) ? [] : json_decode($value, true);
    }

    /**
     * @notes 短信通知获取器
     * @param $value
     * @return array|mixed
     * @author Tab
     * @date 2021/8/18 19:12
     */
    public function getSmsNoticeAttr($value): mixed
    {
        return empty($value) ? [] : json_decode($value, true);
    }

    /**
     * @notes 公众号通知获取器
     * @param $value
     * @return array|mixed
     * @author Tab
     * @date 2021/8/18 19:13
     */
    public function getOaNoticeAttr($value): mixed
    {
        return empty($value) ? [] : json_decode($value, true);
    }

    /**
     * @notes 小程序通知获取器
     * @param $value
     * @return array|mixed
     * @author Tab
     * @date 2021/8/18 19:13
     */
    public function getMnpNoticeAttr($value): mixed
    {
        return empty($value) ? [] : json_decode($value, true);
    }
}