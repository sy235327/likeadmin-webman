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

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 短信记录模型
 * Class SmsLog
 * @package app\common\model
 * @property int $id 主键 id
 * @property int $scene_id 场景id
 * @property string $mobile 手机号码
 * @property string $content 发送内容
 * @property string $code 发送关键字（注册、找回密码）
 * @property int $is_verify 是否已验证；0-否；1-是
 * @property int $check_num 验证次数
 * @property int $send_status 发送状态：0-发送中；1-发送成功；2-发送失败
 * @property int $send_time 发送时间
 * @property string $results 短信结果
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class SmsLog extends BaseModel
{
    use SoftDelete;

    protected $name = 'sms_log';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //场景id
        'scene_id' => 'int',
        //手机号码
        'mobile' => 'string',
        //发送内容
        'content' => 'string',
        //发送关键字（注册、找回密码）
        'code' => 'string',
        //是否已验证；0-否；1-是
        'is_verify' => 'int',
        //验证次数
        'check_num' => 'int',
        //发送状态：0-发送中；1-发送成功；2-发送失败
        'send_status' => 'int',
        //发送时间
        'send_time' => 'int',
        //短信结果
        'results' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
}