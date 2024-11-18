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

namespace app\common\model;

use app\common\enum\CrontabEnum;
use think\model\concern\SoftDelete;

/**
 * 定时任务模型
 * Class Crontab
 * @package app\common\model
 * @property int $id 主键
 * @property string $name 定时任务名称
 * @property int $type 类型 1-定时任务
 * @property int $system 是否系统任务 0-否 1-是
 * @property string $remark 备注
 * @property string $command 命令内容
 * @property string $params 参数
 * @property int $status 状态 1-运行 2-停止 3-错误
 * @property string $expression 运行规则
 * @property string $error 运行失败原因
 * @property int $last_time 最后执行时间
 * @property string $time 实时执行时长
 * @property string $max_time 最大执行时长
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class Crontab extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    protected $name = 'dev_crontab';
    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //定时任务名称
        'name' => 'string',
        //类型 1-定时任务
        'type' => 'int',
        //是否系统任务 0-否 1-是
        'system' => 'int',
        //备注
        'remark' => 'string',
        //命令内容
        'command' => 'string',
        //参数
        'params' => 'string',
        //状态 1-运行 2-停止 3-错误
        'status' => 'int',
        //运行规则
        'expression' => 'string',
        //运行失败原因
        'error' => 'string',
        //最后执行时间
        'last_time' => 'int',
        //实时执行时长
        'time' => 'string',
        //最大执行时长
        'max_time' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];



    /**
     * @notes 类型获取器
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2022/3/29 12:05
     */
    public function getTypeDescAttr($value)
    {
        $desc = [
            CrontabEnum::CRONTAB => '定时任务',
            CrontabEnum::DAEMON => '守护进程',
        ];
        return $desc[$value] ?? '';
    }


    /**
     * @notes 状态获取器
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2022/3/29 12:06
     */
    public function getStatusDescAttr($value)
    {
        $desc = [
            CrontabEnum::START => '运行',
            CrontabEnum::STOP => '停止',
            CrontabEnum::ERROR => '错误',
        ];
        return $desc[$value] ?? '';
    }


    /**
     * @notes 最后执行时间获取器
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2022/3/29 12:06
     */
    public function getLastTimeAttr($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }
}