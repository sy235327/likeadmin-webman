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

namespace app\common\model\file;


use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 文件分类表模型
 * Class FileCate
 * @package app\common\model
 * @property int $id 主键 主键ID
 * @property int $pid 父级ID
 * @property int $type 类型[10=图片，20=视频，30=文件]
 * @property string $name 分类名称
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间

 */
class FileCate extends BaseModel
{
    use SoftDelete;
    protected $name = 'file_cate';

    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 主键ID
        'id' => 'int',
        //父级ID
        'pid' => 'int',
        //类型[10=图片，20=视频，30=文件]
        'type' => 'int',
        //分类名称
        'name' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
}