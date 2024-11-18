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
 * 字典数据模型
 * Class DictData
 * @package app\common\model\dict
 * @property int $id 主键 id
 * @property string $name 数据名称
 * @property string $value 数据值
 * @property int $type_id 字典类型id
 * @property string $type_value 字典类型
 * @property int $sort 排序值
 * @property int $status 状态 0-停用 1-正常
 * @property string $remark 备注
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $delete_time 删除时间
 */
class DictData extends BaseModel
{

    use SoftDelete;

    protected $name = 'dict_data';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //数据名称
        'name' => 'string',
        //数据值
        'value' => 'string',
        //字典类型id
        'type_id' => 'int',
        //字典类型
        'type_value' => 'string',
        //排序值
        'sort' => 'int',
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
     * @date 2022/6/20 16:31
     */
    public function getStatusDescAttr($value, $data)
    {
        return $data['status'] ? '正常' : '停用';
    }

}