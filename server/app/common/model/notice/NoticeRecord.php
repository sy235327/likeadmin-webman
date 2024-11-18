<?php
// +----------------------------------------------------------------------
// | likeshop100%开源免费商用商城系统
// +----------------------------------------------------------------------
// | 欢迎阅读学习系统程序代码，建议反馈是我们前进的动力
// | 开源版本可自由商用，可去除界面版权logo
// | 商业版本务必购买商业授权，以免引起法律纠纷
// | 禁止对系统程序代码以任何目的，任何形式的再发布
// | gitee下载：https://gitee.com/likeshop_gitee
// | github下载：https://github.com/likeshop-github
// | 访问官网：https://www.likeshop.cn
// | 访问社区：https://home.likeshop.cn
// | 访问手册：http://doc.likeshop.cn
// | 微信公众号：likeshop技术社区
// | likeshop团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | // +----------------------------------------------------------------------
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
// +----------------------------------------------------------------------

namespace app\common\model\notice;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 通知记录模型
 * Class Notice
 * @package app\common\model\notice
 * @property int $id 主键 ID
 * @property int $user_id 用户id
 * @property string $title 标题
 * @property string $content 内容
 * @property int $scene_id 场景
 * @property int $read 已读状态;0-未读,1-已读
 * @property int $recipient 通知接收对象类型;1-会员;2-商家;3-平台;4-游客(未注册用户)
 * @property int $send_type 通知发送类型 1-系统通知 2-短信通知 3-微信模板 4-微信小程序
 * @property int $notice_type 通知类型 1-业务通知 2-验证码
 * @property string $extra 其他
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class NoticeRecord extends BaseModel
{
    use SoftDelete;

    protected $name = 'notice_record';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 ID
        'id' => 'int',
        //用户id
        'user_id' => 'int',
        //标题
        'title' => 'string',
        //内容
        'content' => 'string',
        //场景
        'scene_id' => 'int',
        //已读状态;0-未读,1-已读
        'read' => 'int',
        //通知接收对象类型;1-会员;2-商家;3-平台;4-游客(未注册用户)
        'recipient' => 'int',
        //通知发送类型 1-系统通知 2-短信通知 3-微信模板 4-微信小程序
        'send_type' => 'int',
        //通知类型 1-业务通知 2-验证码
        'notice_type' => 'int',
        //其他
        'extra' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];


}