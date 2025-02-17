<?php


namespace app\adminapi\lists\tools;

use app\adminapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\tools\GenerateTable;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 代码生成所选数据表列表
 * Class GenerateTableLists
 * @package app\adminapiapi\lists\tools
 */
class GenerateTableLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 设置搜索条件
     * @return string[][]
     * @author bingo
     * @date 2022/6/14 10:55
     */
    public function setSearch(): array
    {
        return [
            '%like%' => ['table_name', 'table_comment']
        ];
    }


    /**
     * @notes 查询列表
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author bingo
     * @date 2022/6/14 10:55
     */
    public function lists(): array
    {
        return GenerateTable::where($this->searchWhere)
            ->order(['id' => 'desc'])
            ->append(['template_type_desc'])
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取数量
     * @return int
     * @author bingo
     * @date 2022/6/14 10:55
     */
    public function count(): int
    {
        return GenerateTable::count();
    }

}