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

use app\common\enum\YesNoEnum;
use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 资讯管理模型
 * Class Article
 * @package app\common\model\article;
 * @property int $id 主键 文章id
 * @property int $cid 文章分类
 * @property string $title 文章标题
 * @property string $desc 简介
 * @property string $abstract 文章摘要
 * @property string $image 文章图片
 * @property string $author 作者
 * @property string $content 文章内容
 * @property int $click_virtual 虚拟浏览量
 * @property int $click_actual 实际浏览量
 * @property int $is_show 是否显示:1-是.0-否
 * @property int $sort 排序
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class Article extends BaseModel
{
    use SoftDelete;

    protected $name = 'article';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 文章id
        'id' => 'int',
        //文章分类
        'cid' => 'int',
        //文章标题
        'title' => 'string',
        //简介
        'desc' => 'string',
        //文章摘要
        'abstract' => 'string',
        //文章图片
        'image' => 'string',
        //作者
        'author' => 'string',
        //文章内容
        'content' => 'string',
        //虚拟浏览量
        'click_virtual' => 'int',
        //实际浏览量
        'click_actual' => 'int',
        //是否显示:1-是.0-否
        'is_show' => 'int',
        //排序
        'sort' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];

    /**
     * @notes  获取分类名称
     * @param $value
     * @param $data
     * @return string
     * @author heshihu
     * @date 2022/2/22 9:53
     */
    public function getCateNameAttr($value, $data)
    {
        return ArticleCate::where('id', $data['cid'])->value('name');
    }

    /**
     * @notes 浏览量
     * @param $value
     * @param $data
     * @return mixed
     * @author 段誉
     * @date 2022/9/15 11:33
     */
    public function getClickAttr($value, $data)
    {
        return $data['click_actual'] + $data['click_virtual'];
    }


    /**
     * @notes 设置图片域名
     * @param $value
     * @param $data
     * @return array|string|string[]|null
     * @author 段誉
     * @date 2022/9/28 10:17
     */
    public function getContentAttr($value, $data)
    {
        return get_file_domain($value);
    }


    /**
     * @notes 清除图片域名
     * @param $value
     * @param $data
     * @return array|string|string[]
     * @author 段誉
     * @date 2022/9/28 10:17
     */
    public function setContentAttr($value, $data)
    {
        return clear_file_domain($value);
    }


    /**
     * @notes 获取文章详情
     * @param $id
     * @return array
     * @author 段誉
     * @date 2022/10/20 15:23
     */
    public static function getArticleDetailArr(int $id)
    {
        $article = Article::where(['id' => $id, 'is_show' => YesNoEnum::YES])
            ->findOrEmpty();

        if ($article->isEmpty()) {
            return [];
        }

        // 增加点击量
        $article->click_actual += 1;
        $article->save();

        return $article->append(['click'])
            ->hidden(['click_virtual', 'click_actual'])
            ->toArray();
    }

}