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

namespace app\common\model\dept;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;


/**
 * 部门模型
 * Class Dept
 * @package app\common\model\article
 * @property int $id 主键 id
 * @property string $name 部门名称
 * @property int $pid 上级部门id
 * @property int $sort 排序
 * @property string $leader 负责人
 * @property string $mobile 联系电话
 * @property int $status 部门状态（0停用 1正常）
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $delete_time 删除时间
 */
class Dept extends BaseModel
{

    use SoftDelete;

    protected $name = 'dept';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //部门名称
        'name' => 'string',
        //上级部门id
        'pid' => 'int',
        //排序
        'sort' => 'int',
        //负责人
        'leader' => 'string',
        //联系电话
        'mobile' => 'string',
        //部门状态（0停用 1正常）
        'status' => 'int',
        //创建时间
        'create_time' => 'int',
        //修改时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];

    /**
     * @notes 状态描述
     * @param $value
     * @param $data
     * @return string
     * @author 乔峰
     * @date 2022/5/25 18:03
     */
    public function getStatusDescAttr($value, $data)
    {
        return $data['status'] ? '正常' : '停用';
    }

}