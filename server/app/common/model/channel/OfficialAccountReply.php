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

namespace app\common\model\channel;


use app\common\model\BaseModel;

/**
 * 微信公众号回复
 * Class OfficialAccountReply
 * @package app\common\model\channel
 * @property int $id 主键
 * @property string $name 规则名称
 * @property string $keyword 关键词
 * @property int $reply_type 回复类型 1-关注回复 2-关键字回复 3-默认回复
 * @property int $matching_type 匹配方式：1-全匹配；2-模糊匹配
 * @property int $content_type 内容类型：1-文本
 * @property string $content 回复内容
 * @property int $status 启动状态：1-启动；0-关闭
 * @property int $sort 排序
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class OfficialAccountReply extends BaseModel
{

    protected $name = 'official_account_reply';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //规则名称
        'name' => 'string',
        //关键词
        'keyword' => 'string',
        //回复类型 1-关注回复 2-关键字回复 3-默认回复
        'reply_type' => 'int',
        //匹配方式：1-全匹配；2-模糊匹配
        'matching_type' => 'int',
        //内容类型：1-文本
        'content_type' => 'int',
        //回复内容
        'content' => 'string',
        //启动状态：1-启动；0-关闭
        'status' => 'int',
        //排序
        'sort' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];

}