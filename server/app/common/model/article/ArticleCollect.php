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
 * 资讯收藏
 * Class ArticleCollect
 * @package app\common\model\article
 * @property int $id 主键 主键
 * @property int $user_id 用户ID
 * @property int $article_id 文章ID
 * @property int $status 收藏状态 0-未收藏 1-已收藏
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class ArticleCollect extends BaseModel
{
    use SoftDelete;

    protected $name = 'article_collect';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //用户ID
        'user_id' => 'int',
        //文章ID
        'article_id' => 'int',
        //收藏状态 0-未收藏 1-已收藏
        'status' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];

    /**
     * @notes 是否已收藏文章
     * @param $userId
     * @param $articleId
     * @return bool (true=已收藏, false=未收藏)
     * @author 段誉
     * @date 2022/10/20 15:13
     */
    public static function isCollectArticle($userId, $articleId)
    {
        $collect = ArticleCollect::where([
            'user_id' => $userId,
            'article_id' => $articleId,
            'status' => YesNoEnum::YES
        ])->findOrEmpty();

        return !$collect->isEmpty();
    }

}