<?php


namespace app\adminapi\lists\file;


use app\adminapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\file\FileCate;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class FileCateLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 文件分类搜素条件
     * @return string[][]
     * @author 乔峰
     * @date 2021/12/29 14:24
     */
    public function setSearch(): array
    {
        return [
            '=' => ['type']
        ];
    }


    /**
     * @notes 获取文件分类列表
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2021/12/29 14:24
     */
    public function lists(): array
    {
        $lists = (new FileCate())->field(['id,pid,type,name'])
            ->where($this->searchWhere)
            ->order('id desc')
            ->select()->toArray();

        return linear_to_tree($lists, 'children');
    }


    /**
     * @notes 获取文件分类数量
     * @return int
     * @author 乔峰
     * @date 2021/12/29 14:24
     */
    public function count(): int
    {
        return (new FileCate())->where($this->searchWhere)->count();
    }
}