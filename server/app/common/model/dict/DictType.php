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

namespace app\common\model\dict;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;


/**
 * 字典类型模型
 * Class DictType
 * @package app\common\model\dict
 * @property int $id 主键 id
 * @property string $name 字典名称
 * @property string $type 字典类型名称
 * @property int $status 状态 0-停用 1-正常
 * @property string $remark 备注
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $delete_time 删除时间
 */
class DictType extends BaseModel
{

    use SoftDelete;

    protected $name = 'dict_type';

    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //字典名称
        'name' => 'string',
        //字典类型名称
        'type' => 'string',
        //状态 0-停用 1-正常
        'status' => 'int',
        //备注
        'remark' => 'string',
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
     * @date 2022/6/20 15:54
     */
    public function getStatusDescAttr($value, $data)
    {
        return $data['status'] ? '正常' : '停用';
    }

}