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
 */
class DictType extends BaseModel
{

    use SoftDelete;

    protected $deleteTime = 'delete_time';


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