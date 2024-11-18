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

namespace app\common\model\article;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;
use think\model\relation\HasMany;

/**
 * 资讯分类管理模型
 * Class ArticleCate
 * @package app\common\model\article;
 * @property int $id 主键 文章分类id
 * @property string $name 分类名称
 * @property int $sort 排序
 * @property int $is_show 是否显示:1-是;0-否
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class ArticleCate extends BaseModel
{
    use SoftDelete;

    protected $name = 'article_cate';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 文章分类id
        'id' => 'int',
        //分类名称
        'name' => 'string',
        //排序
        'sort' => 'int',
        //是否显示:1-是;0-否
        'is_show' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
    /**
     * @notes 关联文章
     * @return HasMany
     * @author 段誉
     * @date 2022/10/19 16:59
     */
    public function article(): HasMany
    {
        return $this->hasMany(Article::class, 'cid', 'id');
    }


    /**
     * @notes 状态描述
     * @param $value
     * @param $data
     * @return string
     * @author 段誉
     * @date 2022/9/15 11:25
     */
    public function getIsShowDescAttr($value, $data)
    {
        return $data['is_show'] ? '启用' : '停用';
    }


    /**
     * @notes 文章数量
     * @param $value
     * @param $data
     * @return int
     * @author 段誉
     * @date 2022/9/15 11:32
     */
    public function getArticleCountAttr($value, $data)
    {
        return Article::where(['cid' => $data['id']])->count('id');
    }




}