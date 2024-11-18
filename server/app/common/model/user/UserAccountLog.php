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

namespace app\common\model\user;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 账户流水记录模型
 * Class AccountLog
 * @package app\common\model\user
 * @property int $id 主键
 * @property string $sn 流水号
 * @property int $user_id 用户id
 * @property int $change_object 变动对象
 * @property int $change_type 变动类型
 * @property int $action 动作 1-增加 2-减少
 * @property float $change_amount 变动数量
 * @property float $left_amount 变动后数量
 * @property string $source_sn 关联单号
 * @property string $remark 备注
 * @property string $extra 预留扩展字段
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class UserAccountLog extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';
    protected $name = 'user_account_log';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //流水号
        'sn' => 'string',
        //用户id
        'user_id' => 'int',
        //变动对象
        'change_object' => 'int',
        //变动类型
        'change_type' => 'int',
        //动作 1-增加 2-减少
        'action' => 'int',
        //变动数量
        'change_amount' => 'float',
        //变动后数量
        'left_amount' => 'float',
        //关联单号
        'source_sn' => 'string',
        //备注
        'remark' => 'string',
        //预留扩展字段
        'extra' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
}